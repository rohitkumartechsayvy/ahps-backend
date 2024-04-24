<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->days = ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'];
  }

  // FETCH ITEM MODEL
  function itemModel($obj)
  {
    $data['id'] = $obj->id;
    $data['item_name'] = $obj->item_name;
    $data['price'] = $obj->price;
    $data['qty'] = $obj->qty;
    $data['date'] = $obj->date;
    $data['location'] = $obj->location;
    $data['location_lat'] = $obj->location_lat;
    $data['location_long'] = $obj->location_long;
    $data['sku'] = $obj->sku;
    $data['item_img'] = ($obj->item_img) ? url($obj->item_img) : '';
    $data['status'] = $obj->status;
    $data['is_sold'] = $obj->is_sold;
    $data['created_at'] = $obj->created_at;
    $data['updated_at'] = $obj->updated_at;
    return $data;
  }

  public function userGained()
  {
    $response['subscribers_gained']['series'] = [];
    $response['subscribers_gained']['analyticsData']['subscribers'] = 0;
    $data['name'] = 'Users';
    $data['data'] = [28, 40, 36, 52, 38, 60, 55, 28, 40, 36, 52, 38, 60, 55];
    $response['subscribers_gained']['series'][] = $data;
    return apiResponse(200, lang('Item Information Fetched Successfully!'), null, $response);
  }

  public function reportToday()
  {
    $response['purchase_count'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', now()->day)->count();
    $response['purchase_value'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', now()->day)->sum('price');
    $response['sale_count'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', now()->day)->count();
    $response['sale_value'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', now()->day)->sum('price');
    $response['purchase'] = [];
    $pr_items = [];
    $sal_items = [];
    $purchase_data['day'] = Carbon::today()->format('D');
    $purchase_data['date'] = Carbon::today()->toDateString();
    $purchase_data['count'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', now()->day)->count();
    $purchase_data['value'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', now()->day)->sum('price');
    $purchased_items = Item::where('user_id', Auth::user()->id)->whereDay('created_at', now()->day)->get();
    if (isset($purchased_items) && count($purchased_items) > 0) {
      foreach ($purchased_items as $pr_key => $pr_item) {
        $pr_items[] = $this->itemModel($pr_item);
      }
    }
    $purchase_data['items'] = $pr_items;
    $response['purchase'][] = $purchase_data;
    $response['sale'] = [];
    $sale_data['day'] = Carbon::today()->format('D');
    $sale_data['date'] = Carbon::today()->toDateString();
    $sale_data['count'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', now()->day)->count();
    $sale_data['value'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', now()->day)->sum('price');
    $sl_items = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', now()->day)->get();
    if (isset($sl_items) && count($sl_items) > 0) {
      foreach ($sl_items as $sl_key => $sl_item) {
        $sal_items[] = $this->itemModel($sl_item);
      }
    }
    $sale_data['items'] = $sal_items;
    $response['sale'][] = $sale_data;
    return apiResponse(200, lang('Report Information Fetched Successfully!'), null, $response);
  }

  public function reportWeek()
  {
    $date = Carbon::today()->subDays(7);
    $response['purchase_count'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', '>=', $date)->count();
    $response['purchase_value'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', '>=', $date)->sum('price');
    $response['sale_count'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', '>=', $date)->count();
    $response['sale_value'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', '>=', $date)->sum('price');
    foreach (($this->days) as $key => $day) {
      $data['day'] = (Carbon::parse($date)->addDays($key))->format('D');
      $data['date'] = (Carbon::parse($date)->addDays($key))->toDateString();
      $data['count'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', (Carbon::parse($date)->addDays($key))->day)->count();
      $data['value'] = Item::where('user_id', Auth::user()->id)->whereDay('created_at', (Carbon::parse($date)->addDays($key))->day)->sum('price');
      $purchased_items = Item::where('user_id', Auth::user()->id)->whereDay('created_at', (Carbon::parse($date)->addDays($key))->day)->get();
      $pr_items = [];
      if (isset($purchased_items) && count($purchased_items) > 0) {
        foreach ($purchased_items as $pr_key => $pr_item) {
          $pr_items[] = $this->itemModel($pr_item);
        }
      }
      $data['items'] = $pr_items;
      $response['purchase'][] = $data;
    }
    foreach ($this->days as $key => $day) {
      $data['day'] = (Carbon::parse($date)->addDays($key))->format('D');
      $data['date'] = (Carbon::parse($date)->addDays($key))->toDateString();
      $data['count'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', (Carbon::parse($date)->addDays($key))->day)->count();
      $data['value'] = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', (Carbon::parse($date)->addDays($key))->day)->sum('price');
      $sl_items = Item::where('user_id', Auth::user()->id)->whereDay('sold_at', (Carbon::parse($date)->addDays($key))->day)->get();
      $sal_items = [];
      if (isset($sl_items) && count($sl_items) > 0) {
        foreach ($sl_items as $sl_key => $sl_item) {
          $sal_items[] = $this->itemModel($sl_item);
        }
      }
      $data['items'] = $sal_items;
      $response['sale'][] = $data;
    }
    return apiResponse(200, lang('Weekly Report Fetched Successfully!'), null, $response);
  }

  public function reportMonth()
  {
    $date = Carbon::today()->subDays(31);
    $to = Carbon::today()->subDays(1);
    $response['purchase_count'] = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->count();
    $response['purchase_value'] = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->sum('price');
    $response['sale_count'] = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->count();
    $response['sale_value'] = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->sum('price');
    $pr_items = [];
    $sal_items = [];
    $response['purchase'] = [];
    $response['sale'] = [];
    $purchase_data['day'] = $date->format('M') . ' - ' . $to->format('M');
    $purchase_data['date'] = Carbon::parse($date)->toDateString() . ' - ' . Carbon::parse($to)->toDateString();
    $purchase_data['count'] = $response['purchase_count'];
    $purchase_data['value'] = $response['purchase_value'];
    $sale_data['day'] = $date->format('M') . ' - ' . $to->format('M');
    $sale_data['date'] = Carbon::parse($date)->toDateString() . ' - ' . Carbon::parse($to)->toDateString();
    $sale_data['count'] = $response['sale_count'];
    $sale_data['value'] = $response['sale_value'];
    $purchased_items = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->get();
    if (isset($purchased_items) && count($purchased_items) > 0) {
      foreach ($purchased_items as $pr_key => $pr_item) {
        $pr_items[] = $this->itemModel($pr_item);
      }
    }
    $purchase_data['items'] = $pr_items;
    $sl_items = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [Carbon::parse($date)->toDateString(), Carbon::parse($to)->toDateString()])->get();
    if (isset($sl_items) && count($sl_items) > 0) {
      foreach ($sl_items as $sl_key => $sl_item) {
        $sal_items[] = $this->itemModel($sl_item);
      }
    }
    $sale_data['items'] = $sal_items;
    $response['purchase'][] = $purchase_data;
    $response['sale'][] = $sale_data;
    return apiResponse(200, lang('Monthly Report Fetched Successfully!'), null, $response);
  }

  public function customReport(Request $request)
  {
    if (isset($request->date)) {
      $response['purchase_count'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->count();
      $response['purchase_value'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->sum('price');
      $response['sale_count'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', $request->date)->count();
      $response['sale_value'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', $request->date)->sum('price');
      $response['purchase'] = [];
      $pr_items = [];
      $sal_items = [];
      $purchase_data['day'] = Carbon::parse($request->date)->format('D');
      $purchase_data['date'] = Carbon::parse($request->date)->format('Y-m-d');
      $purchase_data['count'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->count();
      $purchase_data['value'] = Item::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->sum('price');
      $purchased_items = Item::where('user_id', Auth::user()->id)->whereDate('created_at', $request->date)->get();
      if (isset($purchased_items) && count($purchased_items) > 0) {
        foreach ($purchased_items as $pr_key => $pr_item) {
          $pr_items[] = $this->itemModel($pr_item);
        }
      }
      $purchase_data['items'] = $pr_items;
      $response['purchase'] = $purchase_data;
      $response['sale'] = [];
      $sale_data['day'] = Carbon::parse($request->date)->format('D');
      $sale_data['date'] = Carbon::parse($request->date)->format('Y-m-d');
      $sale_data['count'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', $request->date)->count();
      $sale_data['value'] = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', $request->date)->sum('price');
      $sl_items = Item::where('user_id', Auth::user()->id)->whereDate('sold_at', $request->date)->get();
      if (isset($sl_items) && count($sl_items) > 0) {
        foreach ($sl_items as $sl_key => $sl_item) {
          $sal_items[] = $this->itemModel($sl_item);
        }
      }
      $sale_data['items'] = $sal_items;
      $response['sale'] = $sale_data;
    }
    if (isset($request->from) && isset($request->to)) {
      $response['purchase_count'] = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [$request->from, $request->to])->count();
      $response['purchase_value'] = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [$request->from, $request->to])->sum('price');
      $response['sale_count'] = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [$request->from, $request->to])->count();
      $response['sale_value'] = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [$request->from, $request->to])->sum('price');
      $pr_items = [];
      $sal_items = [];
      $response['purchase'] = [];
      $response['sale'] = [];
      $purchase_data['day'] = Carbon::parse($request->from)->format('D') . ' - ' . Carbon::parse($request->to)->format('D');
      $purchase_data['date'] = Carbon::parse($request->from)->format('Y-m-d') . ' - ' . Carbon::parse($request->to)->format('Y-m-d');
      $purchase_data['count'] = $response['purchase_count'];
      $purchase_data['value'] = $response['purchase_value'];
      $sale_data['day'] = Carbon::parse($request->from)->format('D') . ' - ' . Carbon::parse($request->to)->format('D');
      $sale_data['date'] = Carbon::parse($request->from)->format('Y-m-d') . ' - ' . Carbon::parse($request->to)->format('Y-m-d');
      $sale_data['count'] = $response['sale_count'];
      $sale_data['value'] = $response['sale_value'];
      $purchased_items = Item::where('user_id', Auth::user()->id)->whereBetween('created_at', [$request->from, $request->to])->get();
      if (isset($purchased_items) && count($purchased_items) > 0) {
        foreach ($purchased_items as $pr_key => $pr_item) {
          $pr_items[] = $this->itemModel($pr_item);
        }
      }
      $purchase_data['items'] = $pr_items;
      $sl_items = Item::where('user_id', Auth::user()->id)->whereBetween('sold_at', [$request->from, $request->to])->get();
      if (isset($sl_items) && count($sl_items) > 0) {
        foreach ($sl_items as $sl_key => $sl_item) {
          $sal_items[] = $this->itemModel($sl_item);
        }
      }
      $sale_data['items'] = $sal_items;
      $response['purchase'][] = $purchase_data;
      $response['sale'][] = $sale_data;
    }
    return apiResponse(200, lang('Report Fetched Successfully!'), null, $response);
  }
}
