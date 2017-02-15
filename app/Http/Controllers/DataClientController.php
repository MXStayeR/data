<?php

namespace App\Http\Controllers;

use App\ClientDMPAllow;
use Illuminate\Http\Request;
use App\DataClient;
use App\DMP;
use Illuminate\Support\Facades\Redis;

class DataClientController extends Controller
{
    
    public function index($id = false)
    {
        if(empty($id))
        {
            return view('clients/list')
                ->with('section', "clients")
                ->with('data_clients', DataClient::all());
        }
        else
        {
            $client = DataClient::find($id);

            return view('clients/edit')
                ->with('section', "clients")
                ->with('client', $client)
                ->with('dmps', DMP::all())
                ->with('security', $client->security);
        }
    }

    public function create()
    {
        $client = new DataClient();
        $client->token = md5(time());
        $client->status = 0;
        $client->save();

        return redirect("clients/".$client->id);
    }

    public function update(Request $r)
    {
        $client = DataClient::find($r->id);

        // Remove current security relationed settings
        $client->security()->delete();
        Redis::del("client::".$client->id."::".$client->security_type."::allow");

        // Remove current allowed DMP relationed settings
        $client->allowedDMPs()->delete();
        Redis::del("client::".$client->id."::dmp::allow");

        $client->name = $r->name;
        if(!empty($r->new_hash))
            $client->token = md5(time());
        $client->status = ($r->status == DataClient::ON) ? DataClient::ON : DataClient::OFF;
        $client->contact_name = $r->contact_name;
        $client->contact_email = $r->contact_email;
        $client->contact_phone = $r->contact_phone;
        $client->security_type = $r->security_type;


        // Security elements
        if(trim($r->security) != "")
        {
            $rows = explode("\n", $r->security);
            if(count($rows) > 0)
            {
                $security = [];
                $class = "App\\Client".ucfirst($client->security_type)."Allow";
                foreach($rows as $item)
                {
                    $security[] = new $class([$client->security_type => trim($item)]);
                }
                $client->security()->saveMany($security);
            }
        }

        //Allowed DMPs
        if(!empty($r->allowed_dmp) && is_array($r->allowed_dmp))
        {
            $allowedDMPobjects = [];
            foreach($r->allowed_dmp as $dmp_id)
            {
                $allowedDMPobjects[] = new ClientDMPAllow(['dmp_id' => $dmp_id]);
            }
            $client->allowedDMPs()->saveMany($allowedDMPobjects);
        }

        $client->save();

        return redirect("clients/".$client->id);
    }

    public function delete(Request $r)
    {
        $client = DataClient::find($r->id);
        $client->security()->delete();
        $client->allowedDMPs()->delete();
        $client->delete();

        return redirect("clients");
    }

}
