<?php

namespace App\Jobs\Work;

use App\Jobs\Job;
use App\Repositories\WorkRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SaveWork extends Job implements SelfHandling
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var \App\Repositories\WorkRepository
     */
    protected $work;

    /**
     * @var null|int
     */
    protected $id;

    /**
     * Create a new job instance.
     *
     * @param array                            $data
     * @param \App\Repositories\WorkRepository $work
     * @param int                              $id
     */
    public function __construct(array $data = [], WorkRepository $work, $id = null)
    {
        $this->data = $data;
        $this->work = $work;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // We build the image
        $this->data['image'] = isset($this->data['image']) ? $this->buildImage($this->data['image']) : null;

        // New Work
        if ($this->id === null) {
            // We assign the author of the work
            $this->assignAuthor();

            return $this->work->create($this->data);
        }

        // Update Work
        return $this->work->update($this->data, $this->id);
    }

    /**
     * Assign the Author of the Work.
     */
    private function assignAuthor()
    {
        $this->data['author_id'] = Auth::user()->id;
    }

    /**
     * Build the Work Image.
     *
     * @param $file
     *
     * @return null|string
     */
    public function buildImage($file)
    {
        $filePath = '/uploads/works/' . $this->data['slug'] . '.' . $file->getClientOriginalExtension();
        Image::make($file)->save(public_path($filePath));

        return $filePath;
    }
}
