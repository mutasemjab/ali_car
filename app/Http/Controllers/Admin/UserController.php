<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Models\Admin;
use App\Models\CardPackage;
use App\Models\Country;
use App\Models\Representative;
use App\Models\SectionUser;
use App\Models\Wallet;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query(); // Assuming user_type 1 is for customers

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where(\DB::raw('CONCAT_WS(" ", `name`, `phone`)'), 'like', '%' . $request->search . '%');
            });
        }


        $data = $query->paginate(PAGINATION_COUNT);

        $searchQuery = $request->search;


        return view('admin.users.index', compact('data', 'searchQuery',));
    }


    public function create()
    {
       return view('admin.users.create');
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
          $customer->phone = $request->get('phone');
           $customer->address = $request->get('address');
           $customer->user_type = $request->get('user_type');
           if($request->activate){
              $customer->activate = $request->get('activate');
          }
          $customer->password = Hash::make($request->password);

          if ($request->has('photo')) {
            $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
            $customer->photo = $the_file_path;
         }
          if($customer->save()){
            Admin::create([
                'name' => $customer->name,
                'username' => $request->name, // Ensure the username is provided
                'password' => $customer->password, // Use the already hashed password
                'user_id' => $customer->id, // Link to the user table
            ]);
              return redirect()->route('users.index')->with(['success' => 'Customer created']);

          }else{
              return redirect()->back()->with(['error' => 'Something wrong']);
          }

      }catch(\Exception $ex){
          return redirect()->back()
          ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
          ->withInput();
      }

    }



    public function edit($id)
    {
        if (auth()->user()->can('customer-edit')) {
            $data = User::findorFail($id);

            return view('admin.users.edit', compact('data'));
        } else {
            return redirect()->back()
                ->with('error', "Access Denied");
        }
    }

       public function update(Request $request,$id)
       {
         $customer=User::findorFail($id);
         try{

             $customer->name = $request->get('name');
             if($request->password){
                $customer->password = Hash::make($request->password);
             }
             $customer->phone = $request->get('phone');
             $customer->user_type = $request->get('user_type');

             if($request->activate){
                $customer->activate = $request->get('activate');
            }
            if ($request->has('photo')) {
                $the_file_path = uploadImage('assets/admin/uploads', $request->photo);
                $customer->photo = $the_file_path;
             }
             if($customer->save()){
                  // Check if the user is also an admin
                $admin = Admin::where('user_id', $customer->id)->first();

                if ($admin) {
                    // Update admin details
                    $admin->name = $customer->name;
                    $admin->username = $customer->name;
                    if ($request->password) {
                        $admin->password = $customer->password; // Keep the same hashed password
                    }
                    $admin->save();
                }
                 return redirect()->route('users.index')->with(['success' => 'Customer update']);

             }else{
                 return redirect()->back()->with(['error' => 'Something wrong']);
             }

         }catch(\Exception $ex){
             return redirect()->back()
             ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
             ->withInput();
         }

      }


}
