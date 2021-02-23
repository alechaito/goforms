<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class EvaluateSeeder extends Seeder
{

    public function run()
    {
        $quiz_id = 57;
        $patient_id = random_int(0, 1000);
        $blocks = DB::table('blocks')->where('id_quiz', $quiz_id)->get();
        foreach($blocks as $block) {
            $questions = DB::table('questions')->where('id_block', $block->id)->get();
            foreach($questions as $qest) {
                if($qest->type == 2){
                    $choices = DB::table('multiple_choices')
                    ->where('id_question', $qest->id)
                    ->get()->first();

                }
                $exploded = explode(',', $choices->choices);
                $values_choice = count($exploded);

                DB::table('evaluates')->insert([
                    'question_id' => $qest->id,
                    'question_name' => $qest->question,
                    'question_response' => random_int(0, $values_choice-1),
                    'question_type' => 2,
                    'patient_id' => $patient_id,
                    'quiz_id' => $quiz_id,
                ]);
            }
        }

    }

}
