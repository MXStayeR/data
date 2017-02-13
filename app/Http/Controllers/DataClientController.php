<?php

namespace App\Http\Controllers;

use App\ClientIpAllow;
use Illuminate\Http\Request;
use App\DataClient;
use Illuminate\Support\Facades\Redis;

class DataClientController extends Controller
{
    
    public function index($id = false)
    {
        if(empty($id))
        {
            return view('data_clients/list')->with('data_clients', DataClient::all());
        }
        else
        {
            $client = DataClient::find($id);

            return view('data_clients/edit')
                    ->with('client', $client)
                    ->with('security', $client->security);
        }
    }

    public function create()
    {
        $client = new DataClient();
        $client->token = md5(time());
        $client->status = 0;
        $client->save();

        return redirect("data_clients/".$client->id);
    }

    public function update(Request $r)
    {
        $client = DataClient::find($r->id);
        $client->name = $r->name;
        if(!empty($r->new_hash))
            $client->token = md5(time());
        //$client->status = 0;
        $client->contact_name = $r->contact_name;
        $client->contact_email = $r->contact_email;
        $client->contact_phone = $r->contact_phone;
        $client->security_type = $r->security_type;

        $client->security()->delete();
        Redis::del("client::".$client->id."::".$client->security_type."::allow");

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

        $client->save();

        return redirect("data_clients/".$client->id);
    }

    public function delete(Request $r)
    {
        $client = DataClient::find($r->id);
        $client->security()->delete();
        $client->delete();

        return redirect("data_clients");
    }

}
