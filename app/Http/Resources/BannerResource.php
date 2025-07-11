<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'redirect_url' => $this->redirect_url,
        ];

        switch ($this->type) {
            case 'banner':
                $data['image'] = $this->banner_img ? url('storage/' . $this->banner_img) : null;
                break;
            case 'benefit':
                $data['product_img'] = $this->product_img ? url('storage/' . $this->product_img) : null;
                $data['benefit_img'] = $this->product_ben_img ? url('storage/' . $this->product_ben_img) : null;
                break;
            case 'video':
                $data['video'] = $this->video ? url('storage/' . $this->video) : null;
                break;
            default:
                // Optionally log or handle invalid type
                $data['error'] = 'Invalid banner type';
                break;
        }

        return $data;
    }
}
