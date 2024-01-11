<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\AppraisalDetails;
use App\Models\Branch;
use App\Models\Competencies;
use App\Models\Employee;
use App\Models\Performance_Type;
use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Models\User;

class AppraisalController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('Manage Appraisal'))
        {
            $user = \Auth::user();
            if($user->type == 'employee')
            {
                $employee   = Employee::where('user_id', $user->id)->first();
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();
                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->where('branch', $employee->branch_id)->where('employee', $employee->id)->get();
                $managerDepartmentId = User::where('id', '=', $user->id)->get()->value('department_id');
                $managerBranchId = User::where('id', '=', $user->id)->get()->value('branch_id');

            }
            else
            {
                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->get();
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();
                $managerDepartmentId = User::where('id', '=', $user->id)->get()->value('department_id');
                $managerBranchId = User::where('id', '=', $user->id)->get()->value('branch_id');

            }

            return view('appraisal.index', compact('appraisals','competencyCount', 'managerDepartmentId', 'managerBranchId'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('Create Appraisal'))
        {
            $employee   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name','id','branch_id');


            $employee->prepend('Select Employee', '');

            $brances = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            //APPRAISAL MODULE CHANGES
            // $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();

            //getting all types i.e created by both company as well a s HR
            $performance_types = Performance_Type::all();

            //for only employee
            $isTypeEmployee = \Auth::user()->type == "employee";
            $EBID   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('branch_id', 'id');
            \Log::info($EBID);
            $branchID = $EBID->get($employee->search(\Auth::user()->name));
            $branchName = Branch::where('id', '=', $branchID)->get()->pluck('name')->first();


            return view('appraisal.create', compact('employee', 'brances', 'performance_types', 'isTypeEmployee', 'branchName', 'branchID'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    // public function store(Request $request)
    // {

    //     if(\Auth::user()->can('Create Appraisal'))
    //     {
    //          $validator = \Auth::user()->type !== "employee" ? \Validator::make(
    //             $request->all(), [
    //                                'brances' => 'required',
    //                                'employee' => 'required',
    //                                'rating'=> 'required',
    //                            ]
    //         ): \Validator::make(
    //             $request->all(), [
    //                             //    'brances' => 'required',
    //                             //    'employee' => 'required',
    //                                'rating'=> 'required',
    //                            ]
    //             );
    //         if($validator->fails())
    //         {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }

    //         $appraisal                 = new Appraisal();
    //         $appraisal->branch         = \Auth::user()->type !== "employee" ? $request->brances : $request->input('brances');
    //         $appraisal->employee       = \Auth::user()->type !== "employee" ? $request->employee : $request->input('employee');
    //         $appraisal->appraisal_date = $request->appraisal_date;
    //         $appraisal->rating         = json_encode($request->rating, true);
    //         $appraisal->remark         = $request->remark;
    //         $appraisal->created_by     = \Auth::user()->creatorId();
    //         $appraisal->appraisal_status = 'Pending';
    //         $appraisal->save();

    //         return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully created.'));
    //     }
    // }

    public function store(Request $request)
{
    if (\Auth::user()->can('Create Appraisal')) {

        if($request->Add_Rating == 0){
        $validator = \Auth::user()->type !== "employee" ?
            \Validator::make($request->all(), [
                'brances' => 'required',
                'employee' => 'required',
                'dynamicInput.*' => 'required', // Validate each dynamicInput
                'rating.*' => 'required', // Validate each rating
                'Add_Rating' => 'required', // Validate button click
            ]) :
            \Validator::make($request->all(), [
                'dynamicInput.*' => 'required', // Validate each dynamicInput
                'rating.*' => 'required', // Validate each rating
                'Add_Rating' => 'required', // Validate button click
            ]);
        }else{
        $validator = \Auth::user()->type !== "employee" ?
            \Validator::make($request->all(), [
                'brances' => 'required',
                'employee' => 'required',
                'dynamicInput.*' => 'required', // Validate each dynamicInput
                'rating.*' => 'required', // Validate each rating
            ]) :
            \Validator::make($request->all(), [
                'dynamicInput.*' => 'required', // Validate each dynamicInput
                'rating.*' => 'required', // Validate each rating
            ]);
        }

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $ratingArray=[];
        foreach ($request->dynamicInput as $key => $input) {
           $ratingArray[] = (int)$request->ratings[$key];
        }

        $appraisal = new Appraisal();
        $appraisal->branch = \Auth::user()->type !== "employee" ? $request->brances : $request->input('brances');
        $appraisal->employee = \Auth::user()->type !== "employee" ? $request->employee : $request->input('employee');
        $appraisal->appraisal_date = $request->appraisal_date;
        $appraisal->rating = json_encode($ratingArray);
        if(\Auth::user()->type !== "employee"){
        $appraisal->remark = $request->remark;
    }
        $appraisal->description = $request->description;
        $appraisal->created_by = \Auth::user()->creatorId();
        $appraisal->appraisal_status = 'Pending';
        $appraisal->save();

        \Log::info($request->dynamicInput);
        \Log::info($request->all());
        \Log::info($request->ratings);

        foreach ($request->dynamicInput as $key => $input) {
            \Log::info('key: '. $key .' input: '.$input);
        }

        // Loop through dynamicInput and rating arrays to save details
        foreach ($request->dynamicInput as $key => $input) {
            $detail = new AppraisalDetails();
            $detail->appraisal_id = $appraisal->id;
            $detail->input_value = $input;
            $detail->rating = $request->ratings[$key];
            $detail->is_manager = 'no';
            $detail->save();
        }

        return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully created.'));
    }
}

    public function show(Appraisal $appraisal)
    {
        $rating = json_decode($appraisal->rating, true);
        //APPRAISAL MODULE CHANGES
        // $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        //getting all types i.e created by both company as well a s HR
        $performance_types = Performance_Type::all();
        $employee = Employee::find($appraisal->employee);
        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();
        $appraisal_details = AppraisalDetails::where('appraisal_id', $appraisal->id)->get();

        $isTypeManager = \Auth::user()->type == "manager";
        $employee2   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name','id','branch_id');



        if ($indicator != null) {
            $ratings = json_decode($indicator->rating, true);
        }else {
            $ratings = null;
        }

        // $ratings = json_decode($indicator->rating, true);
        return view('appraisal.show', compact('appraisal', 'performance_types', 'ratings','rating', 'appraisal_details', 'isTypeManager','employee2', 'employee'));
    }

    public function changeshow(Request $request)
    {
        if($request->Add_Rating == 0){
        if($request->status!=='Reject' && $request->status !== 'Approve'){
            $validator = \Validator::make($request->all(), [
            'dynamicInput.*' => 'required', // Validate each dynamicInput
            'ratings.*' => 'required', //Validate each rating
            'Add_Rating' => 'required', // button click
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
    }
}else{
        if($request->status!=='Reject'){
            $validator = \Validator::make($request->all(), [
            'dynamicInput.*' => 'required', // Validate each dynamicInput
            'ratings.*' => 'required', //Validate each rating
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
    }
}
        // Retrieve the Appraisal instance by its ID
        $appraisal = Appraisal::find($request->appraisal_id);
        $appraisal->appraisal_status = $request->status;
        
       if($request->status !== 'Reject' && $request->status !== 'Approve'){
        $ratingArray=json_decode($appraisal->rating);
        foreach ($request->dynamicInput as $key => $input) {
           $ratingArray[] = (int)$request->ratings[$key];
        }
        $appraisal->rating =  $ratingArray;
       }else{
        $appraisal->rating =  $appraisal->rating;
       }

       if($request->remark){
        $appraisal->remark         = $request->remark;
        }
        $appraisal->save();

        

        if($appraisal->appraisal_status=='Review'){
        // Loop through dynamicInput and rating arrays to save details
        foreach ($request->dynamicInput as $key => $input) {
            $detail = new AppraisalDetails();
            $detail->appraisal_id = $request->appraisal_id;
            $detail->input_value = $input;
            $detail->rating = $request->ratings[$key];
            $detail->is_manager = 'yes';
            $detail->save();
        }
    }

        return redirect()->route('appraisal.index')->with('success', __('Appraisal status successfully updated.'));
    }


    public function edit(Appraisal $appraisal)
    {
        if(\Auth::user()->can('Edit Appraisal'))
        {
            //APPRAISAL MODULE CHANGES
            // $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
            //getting all types i.e created by both company as well a s HR
            $performance_types = Performance_Type::all();

            $employee   = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name','id');
            $employee->prepend('Select Employee', '');

            $brances = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            $rating = json_decode($appraisal->rating,true);

            return view('appraisal.edit', compact('brances', 'employee', 'appraisal', 'performance_types','rating'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Appraisal $appraisal)
    {
        if(\Auth::user()->can('Edit Appraisal'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'brances' => 'required',
                                   'employees' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $appraisal->branch         = $request->brances;
            $appraisal->employee       = $request->employees;
            $appraisal->appraisal_date = $request->appraisal_date;
            // $appraisal->rating         = json_encode($request->rating, true);
           
            $appraisal->description         = $request->description;
            $appraisal->save();

            return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully updated.'));
        }
    }


    public function destroy(Appraisal $appraisal, AppraisalDetails $appraisal_details)
    {
        if(\Auth::user()->can('Delete Appraisal'))
        {
            if($appraisal->created_by == \Auth::user()->creatorId())
            {
                $appraisal->delete();
                $appraisal_details->delete();

                return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function empByStar(Request $request)
    {
        $employee = Employee::find($request->employee);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();

        if ($indicator != null) {
            $ratings = json_decode($indicator->rating, true);
        }else {
            $ratings = null;
        }
        //APPRAISAL MODULE CHANGES
        // $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        //getting all types i.e created by both company as well a s HR
        $performance_types = Performance_Type::all();

        $viewRender = view('appraisal.star', compact('ratings','performance_types'))->render();
        return response()->json(array('success' => true, 'html'=>$viewRender));

    }
    public function empByStar1(Request $request)
    {
        $employee = Employee::find($request->employee);

        $appraisal = Appraisal::find($request->appraisal);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();

        if ($indicator != null) {
            $ratings = json_decode($indicator->rating, true);
        }else {
            $ratings = null;
        }

        // $ratings = json_decode($indicator->rating, true);
        $rating = json_decode($appraisal->rating,true);

        //APPRAISAL MODULE CHANGES
        // $performance_types = Performance_Type::where('created_by', '=', \Auth::user()->creatorId())->get();
        //getting all types i.e created by both company as well a s HR
        $performance_types = Performance_Type::all();
        $viewRender = view('appraisal.staredit', compact('ratings','rating','performance_types'))->render();
        return response()->json(array('success' => true, 'html'=>$viewRender));

    }
    public function getemployee(Request $request)
    {
        $data['employee'] = Employee::where('branch_id',$request->branch_id)->get();



        // $employees = Employee::where('branch_id', $request->branch)->get()->pluck('name', 'id')->toArray();

        return response()->json($data);


    }

    //send email
    // public function sendmailAppraisal($id, Request $request)
    // {
    //     $appraisal              = Appraisal::find($id);
    //     //
    //     $appraisalArr = [
    //         'appraisal_id' => $appraisal->id,
    //     ];
    //     $employee = User::find($appraisal->created_by);
    //     $estArr = [
    //         'email' => $employee->email,
    //         'appraisal_subject' => $appraisal->subject,
    //         'appraisal_employee' => $employee->name,
    //         // 'appraisal_project' => $appraisal,
    //         'appraisal_start_date' => $appraisal->start_date,
    //         'appraisal_end_date' => $appraisal->end_date,
    //     ];
    //     // Send Email
    //     $resp = Utility::sendEmailTemplate('appraisal', [$employee->id => $employee->email], $estArr);
    //     return redirect()->route('appraisal.show', $appraisal->id)->with('success', __(' Mail Send successfully!') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
    //     //
    // }
}
