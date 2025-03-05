<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\CardPackage;
use App\Models\Country;
use App\Models\Representative;
use App\Models\SectionUser;
use App\Models\Wallet;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $query = User::where('user_type', 1); // Assuming user_type 1 is for customers

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`, `email`, `phone`)'), 'like', '%' . $request->search . '%');
            });
        }

        if ($request->dealer) {
            $query->where('user_id', $request->dealer); // Assuming 'user_id' is the dealer
        }

        if ($request->sectionUser) {
            $query->where('section_user_id', $request->sectionUser); // Assuming 'section_user_id' is the section user
        }

        $data = $query->paginate(PAGINATION_COUNT);

        $searchQuery = $request->search;
        $dealers = User::where('user_type', 2)->get(); // Fetch the list of dealers
        $sectionUsers = SectionUser::get(); // Fetch the list of section users

        return view('admin.customers.index', compact('data', 'searchQuery', 'dealers', 'sectionUsers'));
    }


    public function create()
    {
        $cardPackages = CardPackage::all();
        $users = User::where('user_type',2)->get();
        $sectionUsers = SectionUser::get();
       return view('admin.customers.create',compact('cardPackages','users','sectionUsers'));
    }

    public function export(Request $request)
    {
        return Excel::download(new UsersExport($request->search), 'users.xlsx');
    }

    public function store(Request $request)
    {
      try{
          $customer = new User();
          $customer->name = $request->get('name');
          $customer->email = $request->get('email');
          $customer->phone = $request->get('phone');
           $customer->address = $request->get('address');
           $customer->card_package_id = $request->get('cardPackage');
           $customer->user_id = $request->get('user');
           $customer->section_user_id = $request->get('sectionUser');
           $customer->user_type = 1;
           if($request->activate){
              $customer->activate = $request->get('activate');
          }
          $customer->password = Hash::make($request->password);

          if ($request->has('photo')) {
            $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
            $customer->photo = $the_file_path;
         }
          if($customer->save()){
               // Create wallet for the customer
                $wallet = new Wallet();
                $wallet->total = 0; // Set initial total to 0
                $wallet->user_id = $customer->id;
                $wallet->save();
              return redirect()->route('admin.customer.index')->with(['success' => 'Customer created']);

          }else{
              return redirect()->back()->with(['error' => 'Something wrong']);
          }

      }catch(\Exception $ex){
          return redirect()->back()
          ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
          ->withInput();
      }

    }


    public function show($id)
    {
        $data = User::where('user_type',1)->findOrFail($id);
        return view('admin.customers.show',compact('data','children',));
    }


    public function edit($id)
    {
        if (auth()->user()->can('customer-edit')) {
            $data = User::where('user_type',1)->findorFail($id);
            $cardPackages = CardPackage::all();
           $users = User::where('user_type',2)->get();
           $sectionUsers = SectionUser::get();
            return view('admin.customers.edit', compact('data','cardPackages','users','sectionUsers'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

       public function update(Request $request,$id)
       {
         $customer=User::where('user_type',1)->findorFail($id);
         try{

             $customer->name = $request->get('name');
             if($request->password){
                $customer->password = Hash::make($request->password);
             }
             $customer->email = $request->get('email');
             $customer->phone = $request->get('phone');
             $customer->section_user_id = $request->get('sectionUser');
             $customer->address = $request->get('address');
             $customer->card_package_id = $request->get('cardPackage');
             $customer->user_id = $request->get('user');

             if($request->activate){
                $customer->activate = $request->get('activate');
            }
            if ($request->has('photo')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $customer->photo = $the_file_path;
             }
             if($customer->save()){
                 return redirect()->route('admin.customer.index')->with(['success' => 'Customer update']);

             }else{
                 return redirect()->back()->with(['error' => 'Something wrong']);
             }

         }catch(\Exception $ex){
             return redirect()->back()
             ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
             ->withInput();
         }

      }

     //  public function delete($id)
    //     {
    //         try {

    //             $item_row = User::select("name")->where('id','=',$id)->first();

    //             if (!empty($item_row)) {

    //         $flag = User::where('id','=',$id)->delete();;

    //         if ($flag) {
    //             return redirect()->back()
    //             ->with(['success' => '   Delete Succefully   ']);
    //             } else {
    //             return redirect()->back()
    //             ->with(['error' => '   Something Wrong']);
    //             }

    //             } else {
    //             return redirect()->back()
    //             ->with(['error' => '   cant reach fo this data   ']);
    //             }

    //       } catch (\Exception $ex) {

    //             return redirect()->back()
    //             ->with(['error' => ' Something Wrong   ' . $ex->getMessage()]);
    //             }
    //     }


    //   public function ajax_search(Request $request)
    //   {
    //       if ($request->ajax()) {


    //       $search_by_text = $request->search_by_text;
    //       $searchbyradio = $request->searchbyradio;

    //       if ($search_by_text != '') {
    //       if ($searchbyradio == 'customer_code') {
    //       $field1 = "customer_code";
    //       $operator1 = "=";
    //       $value1 = $search_by_text;
    //       } elseif ($searchbyradio == 'account_number') {
    //       $field1 = "account_number";
    //       $operator1 = "=";
    //       $value1 = $search_by_text;
    //       } else {
    //       $field1 = "name";
    //       $operator1 = "like";
    //       $value1 = "%{$search_by_text}%";
    //       }
    //       } else {
    //       //true
    //       $field1 = "id";
    //       $operator1 = ">";
    //       $value1 = 0;
    //       }


    //       $data = User::where($field1, $operator1, $value1)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

    //       return view('admin.customers.ajax_search', ['data' => $data]);
    //       }
    //       }


}
