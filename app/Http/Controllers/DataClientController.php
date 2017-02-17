<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\DataClient;
use App\ClientDMPAllow;
use App\DMP;
use App\Key;

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
        
        $client = DataClient::findOrFail($r->id);

        $fields = [
            'name' => 'required|max:128',
            'token' => 'required|max:64',
            'contact_name' => 'nullable|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|max:32',
        ];
        $messages = [
            //'required' => 'The :attribute field is required.',
        ];
        $validator = Validator::make($r->all(), $fields, $messages);
        if ($validator->fails())
        {
            return redirect('clients/'.$client->id)
                    ->withErrors($validator);
        }
        
        
        


        // Remove current security relationed settings
        $client->security()->delete();
        Redis::del(Key::clientSecurityItems($client->id, $client->security_type));

        // Remove current allowed DMP relationed settings
        $client->allowedDMPs()->delete();
        Redis::del(Key::clientAllowedDMPs($client->id));

        $client->name = $r->has('name') ? $r->name : "";
        if(!empty($r->new_hash))
            $client->token = md5(time());
        $client->status = ($r->status == DataClient::ON) ? DataClient::ON : DataClient::OFF;
        $client->contact_name = $r->has('contact_name') ? $r->contact_name : "";
        $client->contact_email = $r->has('contact_email') ? $r->contact_email : "";
        $client->contact_phone = $r->has('contact_phone') ? $r->contact_phone : "";
        $client->security_type = $r->security_type;


        // Security elements
        if(trim($r->security) != "")
        {
            $rows = explode("\n", $r->security);
            $unique = [];
            if(count($rows) > 0)
            {
                foreach($rows as $item)
                    $unique[trim($item)] = 1;

                $security = [];
                $class = "App\\Client".ucfirst($client->security_type)."Allow";
                foreach($unique as $item => $c)
                    $security[] = new $class([$client->security_type => $item]);

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
        $client = DataClient::findOrFail($r->id);
        $client->security()->delete();
        $client->allowedDMPs()->delete();
        $client->delete();

        return redirect("clients");
    }

}
