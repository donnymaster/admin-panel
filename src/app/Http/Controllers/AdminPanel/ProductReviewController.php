<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\ProductReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UpdateProductReviewRequest;
use App\Models\AdminPanel\ProductReview;
use App\Models\AdminPanel\ProductVariant;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index(Request $request, ProductReviewsDataTable $productReviewsDataTable)
    {
        $variantId = $request->get('variant-id');
        $variant = ProductVariant::where('id', $variantId)->first();

        return $productReviewsDataTable
            ->setVariant($variant)
            ->render('admin-panel.product-reviews.index', compact('variant'));
    }

    public function update(UpdateProductReviewRequest $request, ProductReview $review)
    {
        $review->update($request->safe()->toArray());

        return [
            'message' => 'Комментарий был обновлен!',
        ];
    }

    public function delete(ProductReview $review)
    {
        $review->delete();

        return [
            'message' => 'Комментарий был удален!',
        ];
    }
}
