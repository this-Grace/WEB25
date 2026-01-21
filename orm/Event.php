<?php

/**
 * Event entity class representing an event in the system.
 * Maps to the 'events' table in the database.
 */
class Event
{
    private ?int $event_id;
    private string $event_name;
    private string $event_date;
    private int $eventOwner_id;
    private int $category_id;
    private string $location;
    private float $latitude;
    private float $longitude;
    private ?string $description;
    private ?string $event_url;
    private string $created_at;
    private string $published_at;
    private string $event_status;

    /**
     * Constructor to initialize Event properties.
     * @param array $data Associative array of event properties.
     */
    public function __construct(array $data = [])
    {
        $this->event_id = $data['event_id'] ?? null;
        $this->event_name = $data['event_name'] ?? '';
        $this->event_date = $data['event_date'] ?? '';
        $this->eventOwner_id = $data['eventOwner_id'] ?? 0;
        $this->category_id = $data['category_id'] ?? 0;
        $this->location = $data['location'] ?? '';
        $this->latitude = isset($data['latitude']) ? (float)$data['latitude'] : 0.0;
        $this->longitude = isset($data['longitude']) ? (float)$data['longitude'] : 0.0;
        $this->description = $data['description'] ?? null;
        $this->event_url = $data['event_url'] ?? null;
        $this->created_at = $data['created_at'] ?? '';
        $this->published_at = $data['published_at'] ?? '';
        $this->event_status = $data['event_status'] ?? 'bozza';
    }

    public function getEventId(): ?int
    {
        return $this->event_id;
    }

    public function getEventName(): string
    {
        return $this->event_name;
    }

    public function getEventDate(): string
    {
        return $this->event_date;
    }

    public function getEventOwnerId(): int
    {
        return $this->eventOwner_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEventUrl(): ?string
    {
        return $this->event_url;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getPublishedAt(): string
    {
        return $this->published_at;
    }

    public function getEventStatus(): string
    {
        return $this->event_status;
    }
}
