<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Postcode;

class homeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function checkPost(Request $request){
 
        $fromPostcode = preg_replace('/\s/', '', $request->from);
        $toPostcode = preg_replace('/\s/', '', $request->to);
        
        $unit = $request->unit;
        $validFrom=$this->isPostcodeValid($fromPostcode);
        $validTo=$this->isPostcodeValid($toPostcode);
        

        if(!$validFrom)
        {
            return redirect()->back()->with('message', 'Not Valid Post Code of From');
        }
        if(!$validTo)
        {
            return redirect()->back()->with('message', 'Not Valid Post Code of To');
        }
        
        
        $fromDistance= Postcode::whereRaw("REPLACE(`postcode`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $fromPostcode).'%'])->first();
        $fromLat = $fromDistance->latitude ;
        $fromLon = $fromDistance->longitude ;

        $toDistance= Postcode::whereRaw("REPLACE(`postcode`, ' ' ,'') LIKE ?", ['%'.str_replace(' ', '', $toPostcode).'%'])->first();
        $toLat = $toDistance->latitude ;
        $toLon = $toDistance->longitude ;

        

        #calling functions
        $distance = $this->distance($fromLat,$fromLon,$toLat ,$toLon, $unit );
        
        
        

        return redirect()->back()->with('distance', $distance)->with('unit' ,$unit) 
        ->with('from' ,$fromPostcode)
        ->with('to' ,$toPostcode) ;

            
               
    }
    function isPostcodeValid($postcode)
    {
        
        $postcode = preg_replace('/\s/', '', $postcode);
        
       
        $postcode = strtoupper($postcode);
        
        if(preg_match("/(^[A-Z]{1,2}[0-9R][0-9A-Z]?[\s]?[0-9][ABD-HJLNP-UW-Z]{2}$)/i",$postcode) || preg_match("/(^[A-Z]{1,2}[0-9R][0-9A-Z]$)/i",$postcode))
        {    
            return true;
        }
        else
        {
            return false;
        }
    }
    
     function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
       
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
          $unit = substr( $unit, 0, 1);
         
      
          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
      
    }
}



