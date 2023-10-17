<?php

namespace App\Http\Controllers\AdminPanel;

use App\DataTables\AdminPanel\PromocodesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CreatePromocodeRequest;
use App\Http\Requests\AdminPanel\UpdatePromocodeRequest;
use App\Models\AdminPanel\Promocode;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function index(Request $request, PromocodesDataTable $promocodesDataTable)
    {
        return $promocodesDataTable->render('admin-panel.promocode.index');
    }

    public function store(CreatePromocodeRequest $request)
    {
        Promocode::create($request->safe()->toArray());

        return [
            'message' => 'Промокод был добавлен!'
        ];
    }

    public function delete(Promocode $promocode)
    {
        // $countRelation = Promocode::where('id', $promocode->id)->withCount('productVariant')->first();

        // if ($countRelation->product_variant_count > 0) {
        //     return response([
        //         'message' => 'Невозможно удалить промокод, потому что он используется товаром',
        //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $promocode->delete();

        return [
            'message' => 'Промокод был удален!',
        ];
    }

    public function update(UpdatePromocodeRequest $request, Promocode $promocode)
    {
        $codeRequest = $request->get('code');

        if ($codeRequest) {
            $resultSearch = Promocode::where('code', $codeRequest)->first();

            if ($resultSearch) {
                if ($promocode->id != $resultSearch->id) {
                    return response([
                        'message' => 'Такой код уже существует!',
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }

        $promocode->update(
            array_merge(
                $request->safe()->toArray(),
            )
        );

        return [
            'message' => 'Промокод был обновлен',
        ];
    }
}
