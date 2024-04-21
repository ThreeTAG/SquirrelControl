<?php

namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class TemplateGeneratorController extends Controller
{

    public function addonPack(): Factory|View|Application
    {
        return view('external.template_generator.index');
    }

    public function generateAddonPack(Request $request): BinaryFileResponse
    {
        $name = $request->input('name');
        $description = $request->input('description');
        $version = $request->input('version');
        $packId = $request->input('pack_id');
        $fileName = storage_path('cache/addon-pack');

        if (!file_exists($fileName)) {
            mkdir($fileName, 0777, true);
        }

        $fileName .= '/pack_cache.zip';

        $zip = new ZipArchive();
        if ($zip->open($fileName, ZipArchive::OVERWRITE) !== TRUE) {
            exit("cannot open $fileName\n");
        }

        $zip->addEmptyDir("addon/$packId/accessories");
        $zip->addEmptyDir("addon/$packId/accessory_slots");
        $zip->addEmptyDir("addon/$packId/armor_materials");
        $zip->addEmptyDir("addon/$packId/blocks");
        $zip->addEmptyDir("addon/$packId/creative_mode_tabs");
        $zip->addEmptyDir("addon/$packId/items");
        $zip->addEmptyDir("addon/$packId/kube_js_scripts");
        $zip->addEmptyDir("addon/$packId/particle_types");
        $zip->addEmptyDir("addon/$packId/poi_types");
        $zip->addEmptyDir("addon/$packId/suit_sets");
        $zip->addEmptyDir("addon/$packId/villager_professions");
        $zip->addEmptyDir("addon/$packId/villager_trades");

        $zip->addEmptyDir("data/$packId/kubejs_scripts");
        $zip->addEmptyDir("data/$packId/tags/blocks");
        $zip->addEmptyDir("data/$packId/tags/items");
        $zip->addEmptyDir("data/$packId/tags/damage_type");
        $zip->addEmptyDir("data/$packId/recipes");
        $zip->addEmptyDir("data/$packId/advancements");
        $zip->addEmptyDir("data/$packId/loot_tables");
        $zip->addEmptyDir("data/$packId/palladium/item_powers");
        $zip->addEmptyDir("data/$packId/palladium/loot_table_modifications");
        $zip->addEmptyDir("data/$packId/palladium/powers");
        $zip->addEmptyDir("data/$packId/palladium/suit_set_powers");

        $zip->addEmptyDir("assets/$packId/blockstates");
        $zip->addEmptyDir("assets/$packId/models/block");
        $zip->addEmptyDir("assets/$packId/models/item");
        $zip->addEmptyDir("assets/$packId/textures/block");
        $zip->addEmptyDir("assets/$packId/textures/item");
        $zip->addEmptyDir("assets/$packId/kubejs_scripts");
        $zip->addEmptyDir("assets/$packId/particles");
        $zip->addEmptyDir("assets/$packId/palladium/armor_renderers");
        $zip->addEmptyDir("assets/$packId/palladium/energy_beams");
        $zip->addEmptyDir("assets/$packId/palladium/model_layers");
        $zip->addEmptyDir("assets/$packId/palladium/particle_emitters");
        $zip->addEmptyDir("assets/$packId/palladium/render_layers");
        $zip->addEmptyDir("assets/$packId/palladium/trails");

        $zip->addFromString('pack.mcmeta', $this->loadAndReplaceTemplate('pack.mcmeta', $name, $description, $version, $packId));
        $zip->addFromString('fabric.mod.json', $this->loadAndReplaceTemplate('fabric.mod.json', $name, $description, $version, $packId));
        $zip->addFromString('META-INF/mods.toml', $this->loadAndReplaceTemplate('mods.toml', $name, $description, $version, $packId));

        $zip->close();

        return response()->download($fileName, "$packId-$version.zip", ['Content-Length: ' . filesize($fileName)]);
    }

    private function loadAndReplaceTemplate($path, $name, $description, $version, $packId): array|bool|string
    {
        $template = storage_path('templates/addon_pack/' . $path);
        $content = file_get_contents($template);

        $content = str_replace('%name%', $name, $content);
        $content = str_replace('%pack_id%', $packId, $content);
        $content = str_replace('%version%', $version, $content);
        $content = str_replace('%pack_format%', 15, $content);
        $content = str_replace('%description%', $description, $content);

        return $content;
    }

}
