<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, Uuids;

    protected $table = 'materials';

    protected $fillable = [
        'batch_id',
        'title',
        'mapel',
        'description',
        'tutor_id',
        'type',
        'file_path',
        'youtube_url',
        'external_link',
        'thumbnail_path',
        'file_size',
        'file_type',
        'views_count',
        'downloads_count',
        'is_public',
        'is_featured',
        'tags',
        'content',
        'duration_seconds',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_featured' => 'boolean',
        'tags' => 'array',
        'views_count' => 'integer',
        'downloads_count' => 'integer',
    ];

    /**
     * Get the batch that owns the Material
     */
    public function batch()
    {
        return $this->belongsTo(PaketUjian::class, 'batch_id');
    }

    /**
     * Get the tutor that owns the Material
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment downloads count
     */
    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    /**
     * Scope a query to only include public materials
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include featured materials
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Check if material is downloadable
     */
    public function isDownloadable()
    {
        return in_array($this->type, ['document', 'video']) && $this->file_path;
    }

    /**
     * Get YouTube video ID from URL
     */
    public function extractYoutubeVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getYoutubeThumbnail()
    {
        if ($this->type === 'youtube' && $this->youtube_url) {
            $videoId = $this->extractYoutubeVideoId($this->youtube_url);
            if ($videoId) {
                return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            }
        }
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getYoutubeEmbedUrl()
    {
        if ($this->type === 'youtube' && $this->youtube_url) {
            $videoId = $this->extractYoutubeVideoId($this->youtube_url);
            if ($videoId) {
                return "https://www.youtube.com/embed/{$videoId}";
            }
        }
        return null;
    }

    /**
     * Get type icon
     */
    public function getTypeIcon()
    {
        $icons = [
            'video' => 'video',
            'document' => 'file-pdf',
            'link' => 'link',
            'youtube' => 'youtube',
        ];

        return $icons[$this->type] ?? 'file';
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrl()
    {
        if ($this->type === 'youtube' && $this->youtube_url) {
            return $this->getYoutubeThumbnail();
        }
        
        if ($this->thumbnail_path) {
            return asset('storage/' . $this->thumbnail_path);
        }
        
        return asset('img/default-thumbnail.jpg');
    }

    /**
     * Get embed URL (for YouTube)
     */
    public function getEmbedUrl()
    {
        return $this->getYoutubeEmbedUrl();
    }

    /**
     * Get type badge class
     */
    public function getTypeBadgeClass()
    {
        $classes = [
            'video' => 'bg-danger',
            'document' => 'bg-primary',
            'link' => 'bg-info',
            'youtube' => 'bg-danger',
        ];

        return $classes[$this->type] ?? 'bg-secondary';
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSize()
    {
        if (!$this->file_size) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDuration()
    {
        if (!$this->duration_seconds) {
            return null;
        }

        $hours = floor($this->duration_seconds / 3600);
        $minutes = floor(($this->duration_seconds % 3600) / 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}