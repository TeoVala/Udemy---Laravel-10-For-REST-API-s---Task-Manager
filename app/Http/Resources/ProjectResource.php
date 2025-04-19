<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $main_req = parent::toArray($request);
        $extra_data = [
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'members' => UserResource::collection($this->whenLoaded('members')),
        ];

        return array_merge($main_req, $extra_data);
    }
}
