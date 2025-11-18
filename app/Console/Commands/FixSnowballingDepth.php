<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project\Conducting\PaperSnowballing;

class FixSnowballingDepth extends Command
{
    protected $signature = 'thoth:fix-depth';
    protected $description = 'Corrige hierarquia de depth do snowballing conforme o novo modelo (seed não é salvo).';

    public function handle()
    {
        $this->info("🔧 Corrigindo depth dos registros de snowballing...");

        /**
         * 1) REGISTROS DO PRIMEIRO NÍVEL:
         * parent_snowballing_id = null
         * → antes: depth estava NULL
         * → agora: depth deve ser 1
         */
        $levelOne = PaperSnowballing::whereNull('parent_snowballing_id')->get();

        foreach ($levelOne as $item) {
            $item->depth = 1;
            $item->save();

            // corrige os filhos recursivamente
            $this->fixDepthRecursively($item->id, 1);
        }

        $this->info("✔ Depth corrigido com sucesso!");
        return Command::SUCCESS;
    }

    /**
     * Ajusta recursivamente o depth dos filhos.
     *
     * @param int $parentId
     * @param int $parentDepth
     */
    private function fixDepthRecursively(int $parentId, int $parentDepth)
    {
        $children = PaperSnowballing::where('parent_snowballing_id', $parentId)->get();

        foreach ($children as $child) {

            // depth = depth do pai + 1
            $child->depth = $parentDepth + 1;
            $child->save();

            // recursão para filhos do filho
            $this->fixDepthRecursively($child->id, $child->depth);
        }
    }
}
