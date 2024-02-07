<?php

namespace App\Console\Commands;

use Aternos\CurseForgeApi\ApiException;
use Aternos\CurseForgeApi\Client\CurseForgeAPIClient;
use Aternos\CurseForgeApi\Client\File;
use Aternos\CurseForgeApi\Client\Options\ModFiles\ModFilesOptions;
use Aternos\CurseForgeApi\Model\FileDependency;
use Aternos\ModrinthApi\Client\ModrinthAPIClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportCurseForgeModToModrinth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:curseforge-to-modrinth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports CurseForge Mod to Modrinth';

    protected CurseForgeAPIClient $curseForge;
    protected ModrinthAPIClient $modrinth;

    protected array $dependencyIdMap = [
        230651 => '4h2aTE5G',
        309927 => 'vvuO3ImH',
        238222 => 'u6dRKJwZ',
        349285 => 'EStRwx0r',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->curseForge = new CurseForgeAPIClient(config('mods.curseforge_api_token'));;
        $this->modrinth = new ModrinthAPIClient();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $curseForgeId = '316946';
        $modrinthId = 'KP2WhfaM';
        $cacheFolder = storage_path('/mod_import_cache/');

        if (!file_exists($cacheFolder)) {
            mkdir($cacheFolder);
        }

        try {
            $pagination = $this->curseForge->getMod($curseForgeId)->getFiles((new ModFilesOptions($curseForgeId))->setPageSize(500));
            $files = array_reverse($pagination->getResults());

            foreach ($files as $file) {
                $this->info('Downloading file ' . $file->getData()->getFileName() . '...');
                $filePath = $cacheFolder . $file->getData()->getFileName();

                file_put_contents(
                    $filePath,
                    file_get_contents($file->getData()->getDownloadUrl())
                );

                $this->uploadToModrinth($modrinthId, $file, $filePath);

                sleep(3);
                $this->info('Done!');
            }
        } catch (ApiException $e) {
        }

        return 0;
    }

    public function uploadToModrinth($projectId, File $file, string $filePath): void
    {
        $guzzle = new Client();
        $route = 'https://api.modrinth.com/v2/version';

        try {
            $data = [
                'project_id' => $projectId,
                'name' => $file->getData()->getDisplayName(),
                'version_number' => $this->fetchVersionNumber($file->getData()->getDisplayName()),
                'changelog' => $file->getChangelog(),
                'game_versions' => $this->fetchGameVersions($file->getData()->getGameVersions()),
                'version_type' => $this->convertReleaseType($file->getData()->getReleaseType()),
                'loaders' => ['forge'],
                'featured' => false,
                'dependencies' => $this->convertDependencies($file->getData()->getDependencies()),
                'file_parts' => [
                    'file',
                ],
            ];

            $guzzle->post($route, [
                'headers' => ['Authorization' => 'mrp_hB8mD4zs9Qc80UWokyJrcOCkoJ9NpBuG5iy49tTpLex8lklbCJdsncvoaZss'],
                'multipart' => [
                    [
                        'name' => 'data',
                        'contents' => json_encode($data),
                        'headers' => ['Content-Type' => 'application/json']
                    ],
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($filePath),
                        'filename' => $file->getData()->getFileName(),
                        'headers' => ['Content-Type' => 'application/java-archive']
                    ]
                ],
            ]);
        } catch (GuzzleException $e) {
            $this->error($e->getMessage());
        }
    }

    public function fetchVersionNumber(string $filename): string
    {
        $filename = str_replace('.jar', '', $filename);
        $filename = str_replace('PymTech-', '', $filename);

        return $filename;
    }

    public function convertReleaseType(int|null $releaseType): string
    {
        if ($releaseType === 3) {
            return 'alpha';
        } else if ($releaseType === 2) {
            return 'beta';
        } else {
            return 'release';
        }
    }

    public function fetchGameVersions(array $cfVersions): array
    {
        $versions = [];

        foreach ($cfVersions as $cfVersion) {
            if (preg_match('~[0-9]+~', $cfVersion)) {
                $versions[] = $cfVersion;
            }
        }

        return $versions;
    }

    public function convertDependencies($dependencies): array
    {
        $result = [];

        /** @var FileDependency $dependency */
        foreach ($dependencies as $dependency) {
            if (Arr::has($this->dependencyIdMap, $dependency->getModId())) {
                $type = $dependency->getRelationType();
                $result[] = [
                    'project_id' => $this->dependencyIdMap[$dependency->getModId()],
                    'dependency_type' => $type === 3 ? 'required' : ($type === 2 ? 'optional' : ($type === 5 ? 'incompatible' : ($type === 1 ? 'embedded' : 'optional'))),
                ];
            }
        }

        return $result;
    }
}
