<?php

namespace App\Domain\ValueObjects;

class NutritionInformation
{
    private string $energy;
    private string $fat;
    private string $saturatedFat;
    private string $sugars;
    private string $proteins;
    private string $salt;
    private string $ingredientsText;

    public function __construct(
        string $energy,
        string $fat,
        string $saturatedFat,
        string $sugars,
        string $proteins,
        string $salt,
        string $ingredientsText
    ) {
        $this->energy = $energy;
        $this->fat = $fat;
        $this->saturatedFat = $saturatedFat;
        $this->sugars = $sugars;
        $this->proteins = $proteins;
        $this->salt = $salt;
        $this->ingredientsText = $ingredientsText;
    }

    public function getEnergy(): string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): void
    {
        $this->energy = $energy;
    }

    public function getFat(): string
    {
        return $this->fat;
    }

    public function setFat(string $fat): void
    {
        $this->fat = $fat;
    }

    public function getSaturatedFat(): string
    {
        return $this->saturatedFat;
    }

    public function setSaturatedFat(string $saturatedFat): void
    {
        $this->saturatedFat = $saturatedFat;
    }

    public function getSugars(): string
    {
        return $this->sugars;
    }

    public function setSugars(string $sugars): void
    {
        $this->sugars = $sugars;
    }

    public function getProteins(): string
    {
        return $this->proteins;
    }

    public function setProteins(string $proteins): void
    {
        $this->proteins = $proteins;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }


    public function getIngredientsText(): string
    {
        return $this->ingredientsText;
    }

    public function setIngredientsText(string $ingredientsText): void
    {
        $this->ingredientsText = $ingredientsText;
    }
}
