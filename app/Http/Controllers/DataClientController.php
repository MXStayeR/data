<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataClient;

class DataClientController extends Controller
{
    
    public function index($id = false) {
        if(empty($id)) {

            return view('data_clients/list')->with('data_clients', DataClient::all());
        } else {
            return view('data_clients/edit')->with('client', DataClient::find($id));
        }
    }

    public function create() {

        $client = new DataClient();
        //$client->name = $r->name;
        $client->token = md5(time());
        $client->status = 0;
        //$client->contact_name = $r->contact_name;
        //$client->contact_email = $r->contact_email;
        //$client->contact_phone = $r->contact_phone;
        //$client->security_type = $r->security_type;
        $client->save();


        return redirect("data_clients/".$client->id);

    }

    public function update(Request $r) {

        $client = DataClient::find($r->id);
        $client->name = $r->name;
        //$client->token = md5(time());
        //$client->status = 0;
        $client->contact_name = $r->contact_name;
        $client->contact_email = $r->contact_email;
        $client->contact_phone = $r->contact_phone;
        $client->security_type = $r->security_type;
        $client->save();

        return redirect("data_clients/".$client->id);

    }

    public function delete(Request $r) {

        $client = DataClient::find($r->id);
        $client->delete();

        return redirect("data_clients");
    }

}
