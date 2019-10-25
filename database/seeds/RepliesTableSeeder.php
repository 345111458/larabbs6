<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;


class RepliesTableSeeder extends Seeder
{
    public function run()
    {
    	$faker = app(Faker\Generator::class);
    	$user_id = User::all()->pluck('id')->toArray();
    	$topic_id = Topic::all()->pluck('id')->toArray();

        $replies = factory(Reply::class)->times(8000)->make()->each(function($reply) use ($faker,$user_id,$topic_id){

        	$reply->user_id = $faker->randomElement($user_id);
        	$reply->topic_id = $faker->randomElement($topic_id);
        });

        Reply::insert($replies->toArray());
    }

}

