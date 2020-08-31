<?php


namespace App\Http\Controllers;

use App\{CarModel, Imports\TiresImport, Tires, Vendor};
use Illuminate\{Http\Request, Support\Facades\DB, Support\Facades\Redirect, Support\Facades\Schema};
use Maatwebsite\Excel\Facades\Excel;


class TiresController extends Controller
{
    const service_fields = ['id', 'missing', 'created_at', 'updated_at'];

    public function index()
    {
        $all_tires = Tires::with('vendor', 'model')->get()->toArray();
        $data['Vendors'] = Vendor::all()->toArray();
        $data['Models'] = CarModel::all()->toArray();
        $data['fields'] = array_diff(Schema::getColumnListing(Tires::getTableName()), self::service_fields);
        $data['headers'] = DB::table('tires_prop_name')
            ->select('name', 'code')
            ->get()->pluck('name', 'code')->toArray();
        foreach ($all_tires as $tire) {
            if (empty(json_decode($tire['missing']))) {
                $data['known_tires'][] = $tire;
                continue;
            }
            $data['unknown_tires'][] = $tire;
        }
        return view('list', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'speed_index' => 'max:3|required',
            'diameter' => 'required|string',
            'load_index' => 'required',
            'vendor_id' => 'required',
            'model_id'  => 'required',
            'quantity'  => 'required',
            'price' =>'required'
        ]);
        $data = $request->except('_token');
        if (!empty($data['model_id'])) {
            $data['model_id'] = $this->createModel($data['model_id']);
        }
        if (!empty($data['vendor_id'])) {
            $data['vendor_id'] = $this->createVendor($data['vendor_id']);
        }

        $data['missing'] = json_encode([]);
        $tires = new Tires();
        foreach ($data as $key => $field){
            $tires->$key = $field;
        }
        $tires->save();

        return redirect('/')->with('status', 'Данные обновлены');
    }


    public function uploadPrice(Request $request)
    {
        Excel::import(new TiresImport(), request()->file('price'));
    }

    public function updateTire(Request $request)
    {
        $id = $request->get('id');
        $data = $request->except('_token', 'id');
        if (!empty($data['model_id'])) {
            $data['model_id'] = $this->createModel($data['model_id']);
        }
        if (!empty($data['vendor_id'])) {
            $data['vendor_id'] = $this->createVendor($data['vendor_id']);
        }
        $data['missing'] = json_encode([]);

        Tires::where('id', $id)->update($data);
        return redirect('/')->with('status', 'Данные обновлены');

    }

    private function createModel($name){
        $model = new CarModel();
        $model->name = $name;
        $model->save();
        return $model->id;
    }

    private function createVendor($name){
        $model = new Vendor();
        $model->name = $name;
        $model->save();
        return $model->id;
    }

}
