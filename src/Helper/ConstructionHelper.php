<?php

namespace App\Helper;


use App\Entity\Construction;

class ConstructionHelper
{
    /**
     * Check Construction data to decrement.
     *
     * @param Construction $construction
     * @param array $data
     *
     * @return void
     *
     * @throws \Exception
     */
    static public function decrementData(Construction &$construction, array $data): void
    {
        if (array_key_exists('type', $data)){
            if ($data['type'] === "action") {
                $nb = $construction->getRemainingActions() === 0 ? 0 : $construction->getRemainingActions() - 1;
                $construction->setRemainingActions($nb);
            } else if ($data['type'] === "material") {
                $nb = $construction->getRemainingMaterials() === 0 ? 0 : $construction->getRemainingMaterials() - 1;
                $construction->setRemainingMaterials($nb);
            } else {
                throw new \Exception('Given construction type doesnt works.');
            }
        }
    }
}
