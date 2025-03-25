<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class DaanProject extends Model
{
    protected $table = 'daan_projects';

    protected $fillable = [
        'name',
        'title',
        'description',
        'json_content',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'json_content' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Scope a query to only include active records.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include inactive records.
     */
    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    /**
     * Get the formatted content with proper structure
     */
    protected function formattedContent(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->json_content)) {
                    return [];
                }

                return collect($this->json_content)->map(function ($item) {
                    return $this->formatContentItem($item);
                })->toArray();
            }
        );
    }

    /**
     * Format individual content items based on their type
     */
    protected function formatContentItem($item)
    {
        switch ($item['type'] ?? '') {
            case 'youtube':
                return [
                    'type' => 'youtube',
                    'url' => $item['url'] ?? '',
                    'embed_url' => $this->getYoutubeEmbedUrl($item['url'] ?? '')
                ];
            
            case 'paragraph':
                return [
                    'type' => 'paragraph',
                    'heading' => $item['heading'] ?? '',
                    'content' => $item['content'] ?? ''
                ];
            
            case 'image':
                return [
                    'type' => 'image',
                    'url' => $item['url'] ?? '',
                    'alt' => $item['alt'] ?? ''
                ];
            
            case 'title':
                return [
                    'type' => 'title',
                    'content' => $item['content'] ?? ''
                ];
            
            case 'image-tumbnail':
                return [
                    'type' => 'image-tumbnail',
                    'content' => collect($item['content'] ?? [])->map(function ($thumbnail) {
                        return [
                            'url' => $thumbnail['url'] ?? '',
                            'caption' => $thumbnail['caption'] ?? ''
                        ];
                    })->toArray()
                ];
            
            case 'faq':
                return [
                    'type' => 'faq',
                    'content' => collect($item['content'] ?? [])->map(function ($faq) {
                        return [
                            'question' => $faq['question'] ?? '',
                            'answer' => $faq['answer'] ?? ''
                        ];
                    })->toArray()
                ];
            
            default:
                return $item;
        }
    }

    /**
     * Get YouTube embed URL from regular YouTube URL
     */
    protected function getYoutubeEmbedUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        // Handle different YouTube URL formats
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    }

    /**
     * Get all images from the project content
     */
    public function getAllImages()
    {
        return collect($this->formatted_content)
            ->filter(function ($item) {
                return in_array($item['type'], ['image', 'image-tumbnail']);
            })
            ->map(function ($item) {
                if ($item['type'] === 'image') {
                    return [
                        'url' => $item['url'],
                        'alt' => $item['alt'] ?? '',
                        'type' => 'single'
                    ];
                }
                
                return collect($item['content'])->map(function ($thumbnail) {
                    return [
                        'url' => $thumbnail['url'],
                        'caption' => $thumbnail['caption'],
                        'type' => 'thumbnail'
                    ];
                })->toArray();
            })
            ->flatten(1)
            ->toArray();
    }

    /**
     * Get all FAQs from the project content
     */
    public function getAllFaqs()
    {
        return collect($this->formatted_content)
            ->filter(function ($item) {
                return $item['type'] === 'faq';
            })
            ->map(function ($item) {
                return $item['content'];
            })
            ->flatten(1)
            ->toArray();
    }
} 