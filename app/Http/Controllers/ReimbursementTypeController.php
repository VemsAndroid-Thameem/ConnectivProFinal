<?php

namespace App\Http\Controllers;

use App\Models\ReimbursementType;
use Illuminate\Http\Request;

class ReimbursementTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Reimbursement Type'))
        {
            $reimbursementTypes = ReimbursementType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('reimbursement_type.index')->with('reimbursementTypes', $reimbursementTypes);
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('Create Reimbursement Type'))
        {
            return view('reimbursement_type.create');
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Reimbursement Type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('reimbursement_type.index')->with('error', $messages->first());
            }

            $reimbursementType             = new ReimbursementType();
            $reimbursementType->name       = $request->name;
            $reimbursementType->created_by = \Auth::user()->creatorId();
            $reimbursementType->save();

            return redirect()->route('reimbursement_type.index')->with('success', __('Reimbursement Type successfully created!'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ReimbursementType $reimbursementType
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ReimbursementType $reimbursementType)
    {
        return redirect()->route('reimbursement_type.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ReimbursementType $reimbursementType
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ReimbursementType $reimbursementType)
    {
        if(\Auth::user()->can('Edit Reimbursement Type'))
        {
            if($reimbursementType->created_by == \Auth::user()->creatorId())
            {
                return view('reimbursement_type.edit', compact('reimbursementType'));
            }
            else
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ReimbursementType $reimbursementType
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReimbursementType $reimbursementType)
    {
        // return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        if(\Auth::user()->can('Edit Reimbursement Type'))
        {
            if($reimbursementType->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('reimbursement_type.index')->with('error', $messages->first());
                }

                $reimbursementType->name = $request->name;
                $reimbursementType->save();

                return redirect()->route('reimbursement_type.index')->with('success', __('Reimbursement Type successfully updated!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ReimbursementType $reimbursementType
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReimbursementType $reimbursementType)
    {
        // return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));

        if(\Auth::user()->can('Delete Reimbursement Type'))
        {
            if($reimbursementType->created_by == \Auth::user()->creatorId())
            {
                $reimbursementType->delete();

                return redirect()->route('reimbursement_type.index')->with('success', __('Reimbursement Type successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
