<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Category;
use App\Models\Draft;
use Illuminate\Support\Facades\Log;

class DraftRepository
{
    public function create(array $attrs)
    {
        $draft = Draft::create($attrs);

        $categories = Category::whereIn('id', $attrs['categories'])->pluck('id');
        $draft->categories()->attach($categories);

        $authors = Author::whereIn('id', $attrs['authors'])->pluck('id');
        $draft->authors()->attach($authors);
    }

    public function update(array $attrs, Draft $draft)
    {
        $draft->update($attrs);

        $categories = Category::whereIn('id', $attrs['categories'])->pluck('id');
        $draft->categories()->sync($categories);

        $authors = Author::whereIn('id', $attrs['authors'])->pluck('id');
        $draft->authors()->sync($authors);
    }

    public function delete($draftId)
    {
        $draft = Draft::find($draftId);
        $draft->delete();
    }

    public function updateStatus(array $attrs, $draftId)
    {
        $draft = Draft::find($draftId);
        $draft->update($attrs);
    }
}