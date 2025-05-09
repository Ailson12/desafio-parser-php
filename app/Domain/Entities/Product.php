<?php

namespace App\Domain\Entities;

use App\Domain\Enum\ProductStatusEnum;
use App\Domain\ValueObjects\NutritionInformation;
use InvalidArgumentException;

class Product
{
    private ?string $id;
    private string $code;
    private string $brands;
    private string $categories;
    private string $productName;
    private string $imageUrl;
    private string $importedT;
    private NutritionInformation $nutritionInformation;
    private ProductStatusEnum $status;

    public function __construct(
        string $code,
        string $brands,
        string $categories,
        string $productName,
        string $imageUrl,
        string $importedT,
        NutritionInformation $nutritionInformation,
        ProductStatusEnum $status,
        $id = null
    ) {
        if (!strlen($productName)) {
            throw new InvalidArgumentException('Product name cannot be empty.');
        }

        $this->id = $id;
        $this->code = $code;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->productName = $productName;
        $this->imageUrl = $imageUrl;
        $this->importedT = $importedT;
        $this->status = $status;
        $this->nutritionInformation = $nutritionInformation;
    }

    public function getNutritionInformation(): NutritionInformation
    {
        return $this->nutritionInformation;
    }

    public function setNutritionInformation(NutritionInformation $nutritionInformation): void
    {
        $this->nutritionInformation = $nutritionInformation;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getBrands(): string
    {
        return $this->brands;
    }

    public function setBrands(string $brands): void
    {
        $this->brands = $brands;
    }

    public function getCategories(): string
    {
        return $this->categories;
    }

    public function setCategories(string $categories): void
    {
        $this->categories = $categories;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImportedT(): string
    {
        return $this->importedT;
    }

    public function setImportedT(string $importedT): void
    {
        $this->importedT = $importedT;
    }

    public function getStatus(): ProductStatusEnum
    {
        return $this->status;
    }

    public function setStatus(ProductStatusEnum $status): void
    {
        $this->status = $status;
    }
}
