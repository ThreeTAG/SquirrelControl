<?php

namespace App\Console\Commands;

use App\ModUpdatePost;
use Aternos\CurseForgeApi\ApiException;
use Aternos\CurseForgeApi\Client\CurseForgeAPIClient;
use Aternos\CurseForgeApi\Client\File;
use Aternos\CurseForgeApi\Client\Mod;
use Aternos\CurseForgeApi\Client\Options\ModFiles\ModFilesOptions;
use Aternos\CurseForgeApi\Client\Options\ModSearch\ModLoaderType;
use Aternos\ModrinthApi\Client\ModrinthAPIClient;
use Aternos\ModrinthApi\Client\Project;
use Aternos\ModrinthApi\Client\Version;
use Discord\Builders\Components\ActionRow;
use Discord\Builders\Components\Button;
use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Guild\Emoji;
use Discord\WebSockets\Intents;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CheckModUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:mod-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if mod updates are available and sends message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ApiException
     */
    public function handle(): int
    {
        $entries = ModUpdatePost::query()
            ->where(function (Builder $query) {
                $query->whereNull('curseforge_forge_download')
                    ->orWhereNull('curseforge_fabric_download')
                    ->orWhereNull('modrinth_forge_download')
                    ->orWhereNull('modrinth_fabric_download')
                    ->orWhere('posted', 0);
            })
            ->get();

        $curseForge = new CurseForgeAPIClient('$2a$10$SGMStIiA9s81ArkCSj/rh.lrxIFV3X0qoa426gbzXqp/QxvNOkEna');
        $modrinth = new ModrinthAPIClient();

        /** @var ModUpdatePost $entry */
        foreach ($entries as $entry) {
            $modConfig = config('mods.mods.' . $entry->mod);
            $mMod = null;
            $modrinthFile = null;

            if (is_null($modConfig)) {
                continue;
            }

            if (is_null($entry->curseforge_forge_download) || is_null($entry->curseforge_fabric_download)) {
                $cfMod = $curseForge->getMod($modConfig['curseforge_id']);

                if (is_null($entry->curseforge_forge_download)) {
                    $entry->curseforge_forge_download = $this->findCurseForgeDownload($cfMod, $entry->version, 'forge');
                }

                if (is_null($entry->curseforge_fabric_download)) {
                    $entry->curseforge_fabric_download = $this->findCurseForgeDownload($cfMod, $entry->version, 'fabric');
                }
            }

            if (is_null($entry->modrinth_forge_download) || is_null($entry->modrinth_fabric_download)) {
                try {
                    $mMod = $modrinth->getProject($modConfig['modrinth_id']);

                    if (is_null($entry->modrinth_forge_download)) {
                        $modrinthFile = $this->findModrinthDownload($mMod, $entry->version, 'forge');
                        if ($modrinthFile) {
                            $entry->modrinth_forge_download = $modrinthFile['url'];
                        }
                    }

                    if (is_null($entry->modrinth_fabric_download)) {
                        $modrinthFile = $this->findModrinthDownload($mMod, $entry->version, 'fabric');
                        if ($modrinthFile) {
                            $entry->modrinth_fabric_download = $modrinthFile['url'];
                        }
                    }
                } catch (\Aternos\ModrinthApi\ApiException $e) {
                    $this->error($e->getMessage());
                }
            }

            $entry->save();

            if (!is_null($entry->curseforge_forge_download) && !is_null($entry->curseforge_fabric_download)) {
                if (!is_null($entry->modrinth_forge_download) && !is_null($entry->modrinth_fabric_download)) {
                    try {
                        if (is_null($modrinthFile)) {
                            $modrinthFile = $this->findModrinthDownload(!is_null($mMod) ? $mMod : $modrinth->getProject($modConfig['modrinth_id']), $entry->version, 'forge');
                        }

                        if (!is_null($modrinthFile) && Arr::has($modrinthFile, 'file')) {
                            $this->sendDiscordPost($entry, $modConfig, $modrinthFile['file']);
                        }
                    } catch (\Aternos\ModrinthApi\ApiException $e) {
                        $this->error($e->getMessage());
                    }
                }
            }
        }
        return 0;
    }

    private function sendDiscordPost(ModUpdatePost $post, array $modConfig, Version $modrinthFile): void
    {
        $botToken = config('mods.bot_token');

        if (empty($botToken)) {
            return;
        }

        try {
            $discord = new Discord([
                'token' => $botToken,
                'intents' => Intents::getDefaultIntents(),
            ]);

            $discord->on('ready', function (Discord $discord) use ($post, $modConfig, $modrinthFile) {
                $this->info('Bot Started!');

                /** @var Embed $embed */
                $embed = $discord->factory(Embed::class);
                $embed
                    ->setTitle('New ' . $modrinthFile->getProject()->getData()->getTitle() . ' Update')
                    ->setDescription($modrinthFile->getData()->getChangelog())
                    ->setURL('https://modrinth.com/mod/' . $modrinthFile->getProject()->getData()->getSlug())
                    ->setColor(hexdec($modConfig['color']))
                    ->setThumbnail($modrinthFile->getProject()->getData()->getIconUrl())
                    ->addField($this->makeField($discord, 'Version', $post->version))
                    ->addField($this->makeField($discord, 'Game Version', implode(', ', $modrinthFile->getData()->getGameVersions())));

                $modrinthEmoji = $this->makeEmoji($discord, config('mods.modrinth_emoji'));
                $curseForgeEmoji = $this->makeEmoji($discord, config('mods.curseforge_emoji'));
                $modrinthRow = ActionRow::new()
                    ->addComponent(Button::new(Button::STYLE_LINK)->setEmoji($modrinthEmoji)->setLabel('Forge Download')->setUrl($post->modrinth_forge_download))
                    ->addComponent(Button::new(Button::STYLE_LINK)->setEmoji($modrinthEmoji)->setLabel('Fabric Download')->setUrl($post->modrinth_fabric_download));
                $curseForgeRow = ActionRow::new()
                    ->addComponent(Button::new(Button::STYLE_LINK)->setEmoji($curseForgeEmoji)->setLabel('Forge Download')->setUrl($post->curseforge_forge_download))
                    ->addComponent(Button::new(Button::STYLE_LINK)->setEmoji($curseForgeEmoji)->setLabel('Fabric Download')->setUrl($post->curseforge_fabric_download));

                $discord->getChannel(config('mods.channel_id'))->sendMessage(
                    MessageBuilder::new()
                        ->addEmbed($embed)
                        ->addComponent($modrinthRow)
                        ->addComponent($curseForgeRow)
                )->always(function () use ($discord, $post) {
                    $post->update(['posted' => 1]);
                    $discord->close();
                });
            });
        } catch (IntentException $e) {
            $this->error($e->getMessage());
            Log::error('Error while sending mod update post: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
        }
    }

    private function findCurseForgeDownload(Mod $mod, string $version, string $modLoader): ?string
    {
        try {
            /** @var File $file */
            foreach ($mod->getFiles(new ModFilesOptions($mod->getData()->getId(), null, $modLoader === 'forge' ? ModLoaderType::FORGE : ModLoaderType::FABRIC))->getResults() as $file) {
                $data = $file->getData();
                if (str_contains($data->getFileName(), $version) && $this->gameVersionContainsLoader($data->getGameVersions(), $modLoader)) {
                    if ($data->getIsAvailable()) {
                        return 'https://www.curseforge.com/minecraft/mc-mods/' . $mod->getData()->getSlug() . '/files/' . $data->getId();
                    } else {
                        return null;
                    }
                }
            }
        } catch (ApiException $e) {
            return null;
        }

        return null;
    }

    private function findModrinthDownload(Project $project, string $version, string $modLoader): ?array
    {
        try {
            foreach ($project->getVersions([$modLoader]) as $file) {
                $data = $file->getData();

                if (str_contains($data->getName(), $version) && $data->getStatus() === 'listed' && $this->gameVersionContainsLoader($data->getLoaders(), $modLoader)) {
                    return [
                        'url' => 'https://modrinth.com/mod/' . $project->getData()->getSlug() . '/version/' . $data->getVersionNumber(),
                        'file' => $file,
                    ];
                }
            }
        } catch (\Aternos\ModrinthApi\ApiException $e) {
        }

        return null;
    }

    private function gameVersionContainsLoader(array $versions, string $modLoader): bool
    {
        foreach ($versions as $version) {
            if (strtolower($version) === $modLoader) {
                return true;
            }
        }
        return false;
    }

    private function makeField(Discord $discord, string $name, string $value): Field
    {
        /** @var Field $field */
        $field = $discord->factory(Field::class);
        $field->fill([
            'name' => $name,
            'value' => $value,
        ]);
        return $field;
    }

    private function makeEmoji(Discord $discord, ?string $configInput): ?Emoji
    {
        if (is_null($configInput)) {
            return null;
        }

        /** @var Emoji $emoji */
        $emoji = $discord->factory(Emoji::class);
        $arr = explode(':', $configInput);

        if (count($arr) !== 2) {
            return null;
        }

        $emoji->fill([
            'name' => $arr[0],
            'id' => $arr[1],
        ]);
        return $emoji;
    }

}
