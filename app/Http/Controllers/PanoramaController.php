<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Panorama;

class PanoramaController extends Controller
{

    private $panoramaModel;

    public function __construct(Panorama $panorama){
        $this->panoramaModel = $panorama;
    }


    public function index(){                

        ////dd($this->dolarFuture());

        ////dd('fim');

        return view('panorama.index');
        
                    
    }


    public function dolarFuture(){
        $url = 'https://www2.bmf.com.br/pages/portal/bmfbovespa/lumis/lum-tipo-de-participante-ptBR.asp';
        $urlDatas = file_get_contents($url);
        $var1 = explode('MERCADO FUTURO DE D', $urlDatas);
        $var2 = explode('Investidores Não Residentes', $var1[3]);
        $var3 = explode('TR', $var2[0]);

        //// dd($var3[6]); //// altera o numero que muda o tipo, ex: 6 é os estrangeiros
        
        ################ Não Residentes ###############
        $regrex = '/\>(.*?)\</';
        preg_match_all($regrex, $var3[6], $result);        
        ///dd($result[0]);

        $bought = substr($result[0][3], 1, -1);
        $boughtPercentage = substr($result[0][4], 1, -1);
        $boughtPercentage = str_replace(',','.', $boughtPercentage);
        $sold = substr($result[0][5], 1, -1);
        $soldPercentage = substr($result[0][6], 1, -1);
        $soldPercentage = str_replace(',','.', $soldPercentage);

        $nonResidents['nrBought'] = $bought;
        $nonResidents['nrBoughtPercentage'] = $boughtPercentage;
        $nonResidents['nrSold'] = $sold;
        $nonResidents['nrSoldPercentage'] = $soldPercentage;


        if($this->checkLastDate() != true)
            $this->panoramaModel->create($nonResidents);

        ////dd($nonResidents);
        ##############################################
        ///
        ///return $nonResidents;
        return json_encode('Success Reload Dolar Future');
    }

    public function checkLastDate(){
        $lastResult = $this->panoramaModel->latest()->first();
        
        if($lastResult != null){
            $lastResult = substr($lastResult->created_at, 0, 10);

            if($lastResult === date("Y-m-d"))
                return true;
        }

        return false;

    }

    public function resultNrDolarFuture(){
        
        $twoLast = $this->panoramaModel->take(2)->get();

        $result1 = ($twoLast[0]['nrBought']) - ($twoLast[0]['nrSold']);
        $result2 = ($twoLast[1]['nrBought']) - ($twoLast[1]['nrSold']);

        $result = ($result1) - ($result2);

        ////dd($result);

        $result = round($result, 3);
        return json_encode($result);
    }
}
