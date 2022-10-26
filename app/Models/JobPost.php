<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    
    protected $table = 'job_posts';
    protected $primaryKey = 'job_post_id';

    protected $fillable = ['company_id', 'jobtype_id', 'job_desc', 'category_id', 'salary'];


}
