<?php
namespace App\Models;

class Ship {
    public ?int $id;
    public string $name;
    public string $model;
    public ?int $manufacturer_id;
    public ?int $starship_class_id;
    public ?int $cost_in_credits;
    public ?float $length;
    public ?int $max_speed;
    public ?string $crew;
    public ?int $passengers;
    public ?int $cargo_capacity;
    public ?string $consumables;
    public ?float $hyperdrive_rating;
    public ?int $mglt;
    public ?string $created_at;
    public ?string $edited_at;
    public ?string $api_url;

    public function __construct(
        ?int $id,
        string $name,
        string $model,
        ?int $manufacturer_id,
        ?int $starship_class_id,
        ?int $cost_in_credits = null,
        ?float $length = null,
        ?int $max_speed = null,
        ?string $crew = null,
        ?int $passengers = null,
        ?int $cargo_capacity = null,
        ?string $consumables = null,
        ?float $hyperdrive_rating = null,
        ?int $mglt = null,
        ?string $created_at = null,
        ?string $edited_at = null,
        ?string $api_url = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->manufacturer_id = $manufacturer_id;
        $this->starship_class_id = $starship_class_id;
        $this->cost_in_credits = $cost_in_credits;
        $this->length = $length;
        $this->max_speed = $max_speed;
        $this->crew = $crew;
        $this->passengers = $passengers;
        $this->cargo_capacity = $cargo_capacity;
        $this->consumables = $consumables;
        $this->hyperdrive_rating = $hyperdrive_rating;
        $this->mglt = $mglt;
        $this->created_at = $created_at;
        $this->edited_at = $edited_at;
        $this->api_url = $api_url;
    }
}