<?php


namespace app\Imports;

use App\{CarModel, Tires, Vendor};
use Carbon\Carbon;
use Illuminate\{Support\Facades\DB};
use Maatwebsite\{Excel\Concerns\ToArray, Excel\Concerns\WithStartRow};


class TiresImport implements ToArray, WithStartRow
{
    const pattern = '#(\d+)/?(\d*) R(\d+C?) (\d+)/?\d*([A-z])#';
    const ignore = ['profile', 'missing', 'id'];
    private $names = [];
    private $table_name = '';
    private $test = [];

    public function __construct()
    {
        $this->table_name = Tires::getTableName();
        $this->names = DB::getSchemaBuilder()->getColumnListing($this->table_name);
    }

    /**
     * @param array $array
     */
    public function array(array $array)
    {

        foreach ($array as $row) {
            $fields = [];
            $fields = $this->prepareFields($row);
            $has_row = Tires::select(['id', 'quantity', 'price'])
                ->where('name', $fields['name'])->first();
            if (!empty($has_row)) {
                $has_row->toArray();
                Tires::where('id', $has_row['id'])
                    ->update(['quantity' => $has_row['quantity'], 'price' => $has_row['price']]);
                continue;
            }
            Tires::insert($fields);
        }
    }

    private function prepareFields(array $row)
    {

        $now = Carbon::now()->toDateTimeString();
        $fields['updated_at'] = $now;
        $fields['created_at'] = $now;
        [1 => $fields['name'], 2 => $fields['quantity'], 3 => $fields['price']] = $row;
        preg_match(self::pattern, $fields['name'], $arr_attrs);
        [1 => $fields['width'], 2 => $fields['profile'], 3 => $fields['diameter'], 4 => $fields['load_index'], 5 => $fields['speed_index']] = $arr_attrs;
        if (empty($fields['profile'])) {
            $fields['profile'] = null;
        }
        $resvm = $this->findVendorAndModel($fields['name']);
        if (isset($resvm['vendor_id'])) {
            $fields['vendor_id'] = $resvm['vendor_id'];
        }
        if (isset($resvm['model_id'])) {
            $fields['model_id'] = $resvm['model_id'];
        }
        $missing = array_merge(array_keys(array_filter($fields)), self::ignore);
        $missing = array_diff($this->names, $missing);
        $fields['missing'] = json_encode(array_values($missing));

        return $fields;
    }

    private function findVendorAndModel($name): array
    {
        $result = [];
        $models = [];
        $all_vendor = Vendor::all()->toArray();
        foreach ($all_vendor as $vendor) {
            if (strpos($name, $vendor['name']) !== false) {
                $result['vendor_id'] = $vendor['id'];
                break;
            }
        }
        $models = CarModel::all()->toArray();
        if (!empty($models)) {
            foreach ($models as $model) {
                if (strpos($name, $model['name']) !== false) {
                    $result['model_id'] = $model['id'];
                    break;
                }
            }
        }
        return $result;
    }

    public function startRow(): int
    {
        return 5;
    }
}
