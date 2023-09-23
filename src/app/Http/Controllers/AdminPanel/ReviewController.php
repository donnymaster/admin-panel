<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateReviewRequest;
use App\Models\AdminPanel\Review;

class ReviewController extends Controller
{
    public function index(ReviewsDataTable $reviewsDataTable)
    {
        return $reviewsDataTable->render('admin-panel.reviews.index');
    }

    public function store(UpdateReviewRequest $request, Review $review)
    {
        $data = $request->safe()->toArray();

        $review->update($request->safe(['is_show']));

        $currentPosition = $review->position;
        $newPosition = $data['position'];

        $direction = $currentPosition < $newPosition ? 'right' : 'left';

        if ($direction == 'right') {
            $review->update(['position' => 0]);
            Review::whereBetween('position', [$currentPosition, $newPosition])->decrement('position');
            $review->update(['position' => $newPosition]);
        } else {
            $review->update(['position' => 0]);
            Review::whereBetween('position', [$newPosition, $currentPosition])->increment('position');
            $review->update(['position' => $newPosition]);
        }
        return [
            'message' => 'Комментарий обновлен',
        ];
    }

    public function remove(Review $review)
    {

        Review::where('position', '>=', ++$review->position)->decrement('position');

        $review->delete();

        return [
            'message' => 'Коментарий был удален!',
        ];
    }
}
