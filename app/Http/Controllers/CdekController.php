<?php

namespace App\Http\Controllers;

use CdekSDK2\BaseTypes\Location;
use CdekSDK2\BaseTypes\Package;
use CdekSDK2\BaseTypes\Tariff;
use CdekSDK2\BaseTypes\Tarifflist;
use CdekSDK2\Constraints\Currencies;
use CdekSDK2\Exceptions\AuthException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CdekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getTariffs()
    {
        $client = new Client();
//        $guzzleClient = new GuzzleClient();
//        $client = GuzzleAdapter::createWithConfig([]);
        $cdek = new \CdekSDK2\Client($client);
        $cdek->setAccount('PEBOXHN26rdgqvpYbQbxs1K5XimHWE3Z');
        $cdek->setSecure('5io3CsFJrIytkciYpGd1MBrzHsEQjfor');

        try {
            $cdek->authorize();
            $cdek->getToken();
            $cdek->getExpire();
        } catch (AuthException $exception) {
            //Авторизация не выполнена, не верные account и secure
            echo $exception->getMessage();
        }
//        dd($cdek);

        $tariff = Tariff::create([]);
        $tariff->date = (new \DateTime())->format(\DateTime::ISO8601);
        $tariff->type = Tarifflist::TYPE_ECOMMERCE;
        $tariff->currecy = Currencies::RUBLE;
        $tariff->lang = Tarifflist::LANG_RUS;
//Номера тарифов есть в документации к API: https://api-docs.cdek.ru/63345430.html
        $tariff->tariff_code = 136; //Номер тарифа: Посылка дверь-дверь
        $tariff->from_location = Location::create([
            'address' => '',
            'code' => 44,
            'country_code' => 'RU'
        ]);
        $tariff->to_location = Location::create([
            'address' => '',
            'code' => 1089,
            'country_code' => 'RU'
        ]);
        $tariff->packages = [
            Package::create([
                'weight' => 1000,
                'length' => 30,
                'width' => 20,
                'height' => 10,
            ])
        ];

        $result = $cdek->calculator()->add($tariff);
        if ($result->hasErrors()) {
            // Обрабатываем ошибки
            dd($result->getErrors());
        }

        if ($result->isOk()) {
            //Запрос успешно выполнился
            dd(json_decode($result->getBody(), true));
            $response = $cdek->formatBaseResponse($result, \CdekSDK2\Dto\Tariff::class);
            //В $response будет объект \CdekSDK2\Dto\Tariff::class
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
