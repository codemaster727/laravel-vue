<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnoseReport extends Model
{
    use SoftDeletes;

    /**
     * 初期設定
     *
     * @var string
     */
    protected $table = 'diagnose_reports';
    protected $fillable = [
        'work_id',
        'title',
        'logo'
    ];
    protected $with = [
        'diagnoseReportItems'
    ];

    /**
     * 関数一覧
     *
     * @var string
     */
    public function work()
    {
        return $this->belongsTo('App\Models\Work', 'work_id');
    }

    public function diagnoseReportItems()
    {
        return $this->hasMany('App\Models\DiagnoseReportItem', 'diagnose_report_id');
    }

    public function diagnoseReportShow($id)
    {
        $diagnoseReport = self::find($id);
        return $diagnoseReport;
    }
}
