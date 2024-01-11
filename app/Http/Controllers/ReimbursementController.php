<?php

namespace App\Http\Controllers;

use App\Models\Reimbursement;
use App\Models\ReimbursementType;
use App\Models\ReimbursementAttechment;
use App\Models\ReimbursementComment;
use App\Models\ReimbursementNote;
use App\Models\ActivityLog;
use App\Models\Utility;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            [
                'auth',
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
        if (\Auth::user()->can('Manage Reimbursement')) {
           if (\Auth::user()->type == 'employee') {
                $reimbursements   = Reimbursement::where('employee_name', '=', \Auth::user()->id)->get();
                $curr_month  = Reimbursement::where('employee_name', '=', \Auth::user()->id)->whereMonth('start_date', '=', date('m'))->get();
                $curr_week   = Reimbursement::where('employee_name', '=', \Auth::user()->id)->whereBetween(
                    'start_date',
                    [
                        \Carbon\Carbon::now()->startOfWeek(),
                        \Carbon\Carbon::now()->endOfWeek(),
                    ]
                )->get();
                $last_30days = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();
                $cnt_approved = Reimbursement::where('employee_name', \Auth::user()->id)
                ->where('status', 'accept')
                ->get();
                $cnt_pending = Reimbursement::where('employee_name', \Auth::user()->id)
                ->where('status', 'pending')
                ->get();

                // Reimbursements Summary
                $cnt_reimbursement                = [];
                $cnt_reimbursement['total']       = \App\Models\Reimbursement::getReimbursementSummary($reimbursements);
                $cnt_reimbursement['this_month']  = \App\Models\Reimbursement::getReimbursementSummary($curr_month);
                $cnt_reimbursement['this_week']   = \App\Models\Reimbursement::getReimbursementSummary($curr_week);
                $cnt_reimbursement['last_30days'] = \App\Models\Reimbursement::getReimbursementSummary($last_30days);
                $cnt_reimbursement['approved'] = \App\Models\Reimbursement::getReimbursementSummary($cnt_approved);
                $cnt_reimbursement['pending'] = \App\Models\Reimbursement::getReimbursementSummary($cnt_pending);


                return view('reimbursements.index', compact('reimbursements', 'cnt_reimbursement'));
            }else{

                $reimbursements   = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->get();
                $curr_month  = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->whereMonth('start_date', '=', date('m'))->get();
                $curr_week   = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->whereBetween(
                    'start_date',
                    [
                        \Carbon\Carbon::now()->startOfWeek(),
                        \Carbon\Carbon::now()->endOfWeek(),
                    ]
                )->get();
                $last_30days = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();
                $cnt_approved = Reimbursement::where('created_by', \Auth::user()->creatorId())
                ->where('status', 'accept')
                ->get();
                $cnt_pending = Reimbursement::where('created_by', \Auth::user()->creatorId())
                ->where('status', 'pending')
                ->get();

                // Reimbursement Summary
                $cnt_reimbursement                = [];
                $cnt_reimbursement['total']       = \App\Models\Reimbursement::getReimbursementSummary($reimbursements);
                $cnt_reimbursement['this_month']  = \App\Models\Reimbursement::getReimbursementSummary($curr_month);
                $cnt_reimbursement['this_week']   = \App\Models\Reimbursement::getReimbursementSummary($curr_week);
                $cnt_reimbursement['last_30days'] = \App\Models\Reimbursement::getReimbursementSummary($last_30days);
                $cnt_reimbursement['approved'] = \App\Models\Reimbursement::getReimbursementSummary($cnt_approved);
                $cnt_reimbursement['pending'] = \App\Models\Reimbursement::getReimbursementSummary($cnt_pending);

                $managerDepartmentId = User::where('id', '=', \Auth::user()->id)->get()->value('department_id');
                $managerBranchId = User::where('id', '=', \Auth::user()->id)->get()->value('branch_id');

                return view('reimbursements.index', compact('reimbursements', 'cnt_reimbursement', 'managerDepartmentId', 'managerBranchId'));
            }
        } else {
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
        if (\Auth::user()->can('Create Reimbursement')) {
            $employee       = User::where('type', '=', 'employee')->get()->pluck('name', 'id');

            $reimbursementType = ReimbursementType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('reimbursements.create', compact('reimbursementType', 'employee'));
        } else {
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
        if (\Auth::user()->can('Create Reimbursement')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    //    'name' => 'required|max:20',
                    'subject' => 'required',
                    'value' => 'required',
                    'type' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('reimbursement.index')->with('error', $messages->first());
            }

            $date = explode(' to ', $request->date);

            $reimbursement              = new Reimbursement();
            $reimbursement->employee_name = $request->employee_name;
            $reimbursement->subject     = $request->subject;
            $reimbursement->value       = $request->value;
            $reimbursement->type        = $request->type;
            $reimbursement->start_date  = $request->start_date;
            $reimbursement->end_date    = $request->end_date;
            $reimbursement->description = $request->description;
            $reimbursement->created_by  = \Auth::user()->creatorId();

            $reimbursement->save();

            $settings  = Utility::settings(\Auth::user()->creatorId());

            if (isset($settings['reimbursement_notification']) && $settings['reimbursement_notification'] == 1) {
                // $msg = 'New Invoice ' . Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()) . '  created by  ' . \Auth::user()->name . '.';

                $uArr = [
                    'reimbursement_number' => \Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()),
                    'user_name' => \Auth::user()->name,
                ];
                Utility::send_slack_msg('reimbursement_notification', $uArr);
            }
            if (isset($settings['telegram_reimbursement_notification']) && $settings['telegram_reimbursement_notification'] == 1) {
                // $resp = 'New  Invoice ' . Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()) . '  created by  ' . \Auth::user()->name . '.';

                $uArr = [
                    'reimbursement_number' => \Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()),
                    'user_name' => \Auth::user()->name,
                ];

                Utility::send_telegram_msg('reimbursement_notification', $uArr);
            }
            
            //Mail
            $setings = Utility::settings();

            if ($setings['reimbursement'] == 1) {
                $employee = Employee::where('user_id', '=', $reimbursement->employee_name)->first();

                // Mail for Employee (new_reimbursement template)
                $employeeArr = [
                    'email' => $employee->email,
                    'reimbursement_subject' => $reimbursement->subject,
                    'reimbursement_employee' => $employee->name,
                    'reimbursement_start_date' => $reimbursement->start_date,
                    'reimbursement_end_date' => $reimbursement->end_date,
                ];

                $respEmployee = Utility::sendEmailTemplate('reimbursement', [$employee->email], $employeeArr);
            }

            return redirect()->route('reimbursement.index')->with('success', __('reimbursement successfully created!'));
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    function reimbursementNumber()
    {
        $latest = Reimbursement::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->id + 1;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Reimbursement $reimbursement
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reimbursement = Reimbursement::find($id);
        // return redirect()->route('reimbursement.show');

        if ($reimbursement->created_by == \Auth::user()->creatorId()) {
            $employee   = $reimbursement->employee;

            return view('reimbursements.show', compact('reimbursement', 'employee'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Reimbursement $reimbursement
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Reimbursement $reimbursement)
    {
        if (\Auth::user()->can('Edit Reimbursement')) {
            if ($reimbursement->created_by == \Auth::user()->creatorId()) {
                $employee       = Employee::where('user_id', '=', $reimbursement->employee_name)->get()->value('name');
                $reimbursementType = ReimbursementType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('reimbursements.edit', compact('reimbursement', 'reimbursementType', 'employee'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reimbursement $reimbursement
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reimbursement $reimbursement)
    {
        // return redirect()->back()->with('error', __('This operation is not perform due to demo mode.'));
        if (\Auth::user()->can('Edit Reimbursement')) {
            if ($reimbursement->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        //    'name' => 'required|max:20',
                        'subject' => 'required',
                        'value' => 'required',
                        'type' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('reimbursements.index')->with('error', $messages->first());
                }

                $date = explode(' to ', $request->date);

                $reimbursement->employee_name = $request->employee_name;
                $reimbursement->subject     = $request->subject;
                $reimbursement->value       = $request->value;
                $reimbursement->type        = $request->type;
                $reimbursement->start_date  = $request->start_date;
                $reimbursement->end_date    = $request->end_date;
                $reimbursement->description = $request->description;

                $reimbursement->save();

                return redirect()->route('reimbursement.index')->with('success', __('Reimbursement successfully updated!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reimbursement $reimbursement
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if (\Auth::user()->can('Delete Reimbursement')) {
            $reimbursement = Reimbursement::find($id);
            if ($reimbursement->created_by == \Auth::user()->creatorId()) {

                $attechments = $reimbursement->ReimbursementAttechment()->get()->each;

                foreach ($attechments->items as $attechment) {
                    if (\Storage::exists('reimbursement_attechment/' . $attechment->files)) {
                        unlink('storage/reimbursement_attechment/' . $attechment->files);
                    }
                    $attechment->delete();
                }

                $reimbursement->ReimbursementComment()->get()->each->delete();
                $reimbursement->ReimbursementNote()->get()->each->delete();
                $reimbursement->delete();

                return redirect()->route('reimbursement.index')->with('success', __('reimbursement successfully deleted!'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function descriptionStore($id, Request $request)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr' || \Auth::user()->type == 'employee') {
            $reimbursement        = Reimbursement::find($id);
            $reimbursement->reimbursement_description = $request->reimbursement_description;
            $reimbursement->save();
            return redirect()->back()->with('success', __('Description successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }

    public function fileUpload($id, Request $request)
    {
        $reimbursement = Reimbursement::find($id);
        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr' || \Auth::user()->type == 'employee') {
            $request->validate(['file' => 'required']);
            $dir = 'reimbursement_attechment/';
            $files = $request->file->getClientOriginalName();
            $path = Utility::upload_file($request, 'file', $files, $dir, []);
            if ($path['flag'] == 1) {
                $file = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $file                 = ReimbursementAttechment::create(
                [
                    'reimbursement_id' => $request->reimbursement_id,
                    'user_id' => \Auth::user()->id,
                    'files' => $files,
                ]
            );
            $return               = [];
            $return['is_success'] = true;
            $return['download']   = route(
                'reimbursements.file.download',
                [
                    $reimbursement->id,
                    $file->id,
                ]
            );
            $return['delete']     = route(
                'reimbursements.file.delete',
                [
                    $reimbursement->id,
                    $file->id,
                ]
            );

            return response()->json($return);
        } elseif (\Auth::user()->type == 'employee' && $reimbursement->status == 'accept') {
            $request->validate(['file' => 'required']);
            $dir = 'reimbursement_attechment/';
            $files = $request->file->getClientOriginalName();
            $path = Utility::upload_file($request, 'file', $files, $dir, []);
            if ($path['flag'] == 1) {
                $file = $path['url'];
            } else {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $file                 = ReimbursementAttechment::create(
                [
                    'reimbursement_id' => $request->reimbursement_id,
                    'user_id' => \Auth::user()->id,
                    'files' => $files,
                ]
            );
            $return               = [];
            $return['is_success'] = true;
            $return['download']   = route(
                'reimbursements.file.download',
                [
                    $reimbursement->id,
                    $file->id,
                ]
            );
            $return['delete']     = route(
                'reimbursements.file.delete',
                [
                    $reimbursement->id,
                    $file->id,
                ]
            );

            return response()->json($return);
        } else {
            return response()->json(
                [
                    'is_success' => false,
                    'error' => __('Permission Denied.'),
                ],
                401
            );
        }
    }

    public function fileDownload($id, $file_id)
    {
        $reimbursement = Reimbursement::find($id);
        if ($reimbursement->created_by == \Auth::user()->creatorId()) {
            $file = ReimbursementAttechment::find($file_id);
            if ($file) {
                $file_path = storage_path('reimbursement_attechment/' . $file->files);

                // $files = $file->files;

                return \Response::download(
                    $file_path,
                    $file->files,
                    [
                        'Content-Length: ' . filesize($file_path),
                    ]
                );
            } else {
                return redirect()->back()->with('error', __('File is not exist.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function fileDelete($id, $file_id)
    {
        if (\Auth::user()->can('Delete Attachment')) {
            $reimbursement = Reimbursement::find($id);
            $file = ReimbursementAttechment::find($file_id);
            if ($file) {
                $path = storage_path('reimbursement_attechment/' . $file->files);
                if (file_exists($path)) {
                    \File::delete($path);
                }
                $file->delete();

                return redirect()->back()->with('success', __('Attachment successfully deleted!'));
            } else {
                return response()->json(
                    [
                        'is_success' => false,
                        'error' => __('File is not exist.'),
                    ],
                    200
                );
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function commentStore(Request $request, $id)
    {
        // if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr' || \Auth::user()->type == 'employee') {
        // if (\Auth::user()->can('Store Comment')) {

            $reimbursement              = new ReimbursementComment();
            $reimbursement->comment     = $request->comment;
            $reimbursement->reimbursement_id = $id;
            $reimbursement->user_id     = \Auth::user()->id;
            $reimbursement->save();


            return redirect()->back()->with('success', __('comments successfully created!') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''))->with('status', 'comments');
        // } else {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }
    }

    public function commentDestroy($id)
    {
        if (\Auth::user()->can('Delete Comment')) {
            $reimbursement = ReimbursementComment::find($id);

            $reimbursement->delete();

            return redirect()->back()->with('success', __('Comment successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function noteStore(Request $request, $id)
    {
        if (\Auth::user()->can('Store Note')) {
            $reimbursement              = Reimbursement::find($id);

            $notes                 = new ReimbursementNote();
            $notes->reimbursement_id    = $reimbursement->id;
            $notes->note           = $request->note;
            $notes->user_id        = \Auth::user()->id;
            $notes->save();
            return redirect()->back()->with('success', __('Note successfully saved.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied'));
        }
    }

    public function noteDestroy($id)
    {
        $reimbursement = ReimbursementNote::find($id);
        if (\Auth::user()->can('Delete Note')) {

            $reimbursement->delete();

            return redirect()->back()->with('success', __('Note successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function copyreimbursement($id)
    {
        if (\Auth::user()->can('Create reimbursement')) {
            $reimbursement = Reimbursement::find($id);
            if ($reimbursement->created_by == \Auth::user()->creatorId()) {
                $employee       = User::where('type', '=', 'employee')->get()->pluck('name', 'id');
                $reimbursementType = ReimbursementType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('reimbursements.copy', compact('reimbursement', 'reimbursementType', 'employee'));
            } else {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function copyreimbursementstore($Reimbursement, Request $request)
    {
        if (\Auth::user()->can('Create Reimbursement')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    //    'name' => 'required|max:20',
                    'subject' => 'required',
                    'value' => 'required',
                    'type' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('reimbursements.index')->with('error', $messages->first());
            }

            $date = explode(' to ', $request->date);

            $reimbursement                    = new Reimbursement();
            $reimbursement->employee_name     = $request->employee_name;
            $reimbursement->subject           = $request->subject;
            $reimbursement->value             = $request->value;
            $reimbursement->type              = $request->type;
            $reimbursement->start_date        = $request->start_date;
            $reimbursement->end_date          = $request->end_date;
            $reimbursement->description       = $request->description;
            $reimbursement->created_by        = \Auth::user()->creatorId();

            $reimbursement->save();

            $settings  = Utility::settings(\Auth::user()->creatorId());

            if (isset($settings['reimbursement_notification']) && $settings['reimbursement_notification'] == 1) {
                // $msg = 'New Invoice ' . Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()) . '  created by  ' . \Auth::user()->name . '.';

                $uArr = [
                    'reimbursement_number' => \Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()),
                    'user_name' => \Auth::user()->name,
                ];
                Utility::send_slack_msg('reimbursement_notification', $uArr);
            }
            if (isset($settings['telegram_reimbursement_notification']) && $settings['telegram_reimbursement_notification'] == 1) {
                // $resp = 'New  Invoice ' . Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()) . '  created by  ' . \Auth::user()->name . '.';

                $uArr = [
                    'reimbursement_number' => \Auth::user()->reimbursementNumberFormat($this->reimbursementNumber()),
                    'user_name' => \Auth::user()->name,
                ];

                Utility::send_telegram_msg('reimbursement_notification', $uArr);
            }

            return redirect()->route('reimbursement.index')->with('success', __('Reimbursement successfully created!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function printReimbursement($id)
    {
        $reimbursement  = Reimbursement::findOrFail($id);
        $settings = Utility::settings();
        $employee   = $reimbursement->employee_name;
        //Set your logo
        $logo         = asset(\Storage::url('uploads/logo/'));
        $dark_logo    = Utility::getValByName('company_logo');
        $img = asset($logo . '/' . (isset($dark_logo) && !empty($dark_logo) ? $dark_logo : 'logo-dark.png'));
        return view('reimbursements.reimbursement_view', compact('reimbursement', 'employee', 'img', 'settings'));
    }

    public function pdffromreimbursement($reimbursement_id)
    {
        $id = \Illuminate\Support\Facades\Crypt::decrypt($reimbursement_id);

        $reimbursement  = Reimbursement::findOrFail($id);


        if (\Auth::check()) {
            $usr = \Auth::user();
        } else {

            $usr = User::where('id', $reimbursement->created_by)->first();
        }
        $logo         = asset(\Storage::url('uploads/logo/'));
        $dark_logo    = Utility::getValByName('dark_logo');
        $img = asset($logo . '/' . (isset($dark_logo) && !empty($dark_logo) ? $dark_logo : 'logo-dark.png'));

        return view('reimbursements.template', compact('reimbursement', 'usr', 'img'));
    }

    public function signature($id)
    {
        $reimbursement = Reimbursement::find($id);

        return view('reimbursements.signature', compact('reimbursement'));
    }

    public function signatureStore(Request $request)
    {
        $reimbursement              = Reimbursement::find($request->reimbursement_id);

        if (\Auth::user()->type == 'company' || \Auth::user()->type == 'hr') {
            $reimbursement->company_signature       = $request->company_signature;
        }
        if (\Auth::user()->type == 'employee') {
            $reimbursement->employee_signature       = $request->employee_signature;
        }

        $reimbursement->save();

        return response()->json(
            [
                'Success' => true,
                'message' => __('Reimbursement Signed successfully'),
            ],
            200
        );
    }

    public function sendmailReimbursement($id, Request $request)
    {
        $reimbursement              = Reimbursement::find($id);
        //
        $reimbursementArr = [
            'reimbursement_id' => $reimbursement->id,
        ];
        $employee = User::find($reimbursement->employee_name);
            // Log::info('Employee name retrieved: ' . $employee->name);

        // $employeeId = $reimbursement->employee_name;
        // $employee = User::find($employeeId);

        $estArr = [
            'reimbursement_subject' => $reimbursement->subject,
            'reimbursement_employee' => $employee->name,
            'reimbursement_value' => $reimbursement->value,
            'reimbursement_status' => $reimbursement->status,
            // 'reimbursement_project' => $reimbursement,
            'reimbursement_start_date' => $reimbursement->start_date,
            'reimbursement_end_date' => $reimbursement->end_date,
        ];
        // Send Email
        $resp = Utility::sendEmailTemplate('reimbursement', [$employee->id => $employee->email], $estArr);
        return redirect()->route('reimbursement.show', $reimbursement->id)->with('success', __(' Mail Send successfully!') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        //
    }


    public function reimbursement_status_edit(Request $request, $id)
{
    // Find the Reimbursement model by ID
    $reimbursement = Reimbursement::find($id);
    \Log::info($reimbursement);

    // Check if the reimbursement record was found
    if ($reimbursement) {
        // Update the status and other fields
        $reimbursement->status = $request->status;
        $reimbursement->updated_by = \Auth::user()->type;

        // Save the changes
        $reimbursement->save();

        // You might also want to return a response or redirect here
        return response()->json(['success' => true, 'message' => 'Status updated. Please notify the user by clicking the mail button.']);
    } else {
        // Handle the case where the reimbursement record was not found
        return response()->json(['success' => false, 'message' => 'Reimbursement not found'], 404);
    }
}


}
