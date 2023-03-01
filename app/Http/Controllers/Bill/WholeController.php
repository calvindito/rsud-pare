<?php

namespace App\Http\Controllers\Bill;

use App\Models\Patient;
use App\Models\Setting;
use App\Models\Inpatient;
use App\Models\Operation;
use App\Models\LabRequest;
use App\Models\Outpatient;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\RadiologyRequest;
use App\Models\DispensaryRequest;
use Illuminate\Support\Facades\DB;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;

class WholeController extends Controller
{
    public function index(Request $request)
    {
        $hasSearching = null;
        $patient = null;
        $outpatient = null;
        $inpatient = null;
        $emergencyDepartment = null;
        $laboratorium = null;
        $radiology = null;
        $operation = null;
        $recipe = null;
        $patientId = $request->patient_id;

        if ($request->has('pay') && $request->pay == csrf_token() && $request->method() == 'POST') {
            $patient = Patient::findOrFail($request->patient_id);

            try {
                DB::transaction(function () use ($patient) {
                    foreach ($patient->emergencyDepartment()->where('paid', false)->get() as $ed) {
                        EmergencyDepartment::find($ed->id)->update(['paid' => true]);

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => EmergencyDepartment::class,
                            'transactionable_id' => $ed->id,
                            'nominal' => $ed->totalAction()
                        ]);
                    }

                    foreach ($patient->inpatient()->where('paid', false)->get() as $i) {
                        Inpatient::find($i->id)->update(['paid' => true]);

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => Inpatient::class,
                            'transactionable_id' => $i->id,
                            'nominal' => $i->totalAction()
                        ]);
                    }

                    foreach ($patient->labRequest()->where('paid', false)->get() as $lr) {
                        LabRequest::find($lr->id)->update(['paid' => true]);

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => LabRequest::class,
                            'transactionable_id' => $lr->id,
                            'nominal' => $lr->total()
                        ]);
                    }

                    $medicineAndTool = $patient->dispensaryRequest()
                        ->where('paid', false)
                        ->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')
                        ->get();

                    foreach ($medicineAndTool as $dr) {
                        DispensaryRequest::with('dispensaryItemStock')
                            ->where('dispensary_requestable_type', $dr->dispensary_requestable_type)
                            ->where('dispensary_requestable_id', $dr->dispensary_requestable_id)
                            ->where('dispensary_id', $dr->dispensary_id)
                            ->update(['paid' => true]);

                        foreach ($dr->dispensaryRequestItem() as $dri) {
                            $price = $dri->price_sell;
                            $discount = $dri->discount;
                            $qty = $dri->qty;
                            $nett = $price * $qty;

                            if ($discount > 0) {
                                $nett = ($price - (($discount / 100) * $price)) * $qty;
                            }

                            Transaction::create([
                                'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                                'transactionable_type' => DispensaryRequest::class,
                                'transactionable_id' => $dri->id,
                                'nominal' => $nett
                            ]);
                        }
                    }

                    foreach ($patient->operation()->where('paid', false)->get() as $o) {
                        Operation::find($o->id)->update(['paid' => true]);

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => Operation::class,
                            'transactionable_id' => $o->id,
                            'nominal' => $o->total(false)
                        ]);
                    }

                    foreach ($patient->outpatient()->where('paid', false)->get() as $o) {
                        Outpatient::find($o->id)->update(['paid' => true]);

                        if ($o->outpatientAction->count() > 0) {
                            foreach ($o->outpatientAction as $oa) {
                                $oa->update(['status' => true]);
                            }
                        }

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => Outpatient::class,
                            'transactionable_id' => $o->id,
                            'nominal' => $o->totalAction()
                        ]);
                    }

                    foreach ($patient->radiologyRequest()->where('paid', false)->get() as $rr) {
                        RadiologyRequest::find($rr->id)->update(['paid' => true]);

                        Transaction::create([
                            'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                            'transactionable_type' => RadiologyRequest::class,
                            'transactionable_id' => $rr->id,
                            'nominal' => $rr->total()
                        ]);
                    }
                });

                return redirect('bill/whole')->with(['success' => 'Pembayaran tagihan pasien berhasil disimpan']);
            } catch (\Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        }

        if ($request->_token == csrf_token()) {
            $hasSearching = 'exists';
            $patient = Patient::find($patientId);

            if (!$patient) {
                $hasSearching = 'not-exists';
            } else {
                $patient = $patient;
                $outpatient = $patient->outpatient()->where('paid', false)->get();
                $inpatient = $patient->inpatient()->where('paid', false)->get();
                $emergencyDepartment = $patient->emergencyDepartment()->where('paid', false)->get();
                $laboratorium = $patient->labRequest()->where('paid', false)->get();
                $radiology = $patient->radiologyRequest()->where('paid', false)->get();
                $operation = $patient->operation()->where('paid', false)->get();
                $recipe = $patient->dispensaryRequest()->where('paid', false)->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')->get();
            }
        }

        $data = [
            'hasSearching' => $hasSearching,
            'patient' => $patient,
            'outpatient' => $outpatient,
            'inpatient' => $inpatient,
            'emergencyDepartment' => $emergencyDepartment,
            'laboratorium' => $laboratorium,
            'radiology' => $radiology,
            'operation' => $operation,
            'recipe' => $recipe,
            'totalOutpatient' => 0,
            'totalInpatient' => 0,
            'totalEmergencyDepartment' => 0,
            'totalLab' => 0,
            'totalRadiology' => 0,
            'totalOperation' => 0,
            'totalRecipe' => 0,
            'total' => 0,
            'content' => 'bill.whole'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
