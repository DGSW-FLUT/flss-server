<?php
/**
 * Created by PhpStorm.
 * User: Jin
 * Date: 2018-09-29
 * Time: 오후 7:41
 */

namespace App;

use Illuminate\Support\Facades\DB;

class Quiz
{
    protected $Lno;

    protected $question;

    protected $ranswer;

    protected $items;

    /**
     * @return mixed
     */
    public function getLno()
    {
        return $this->Lno;
    }

    /**
     * @param mixed $Lno
     */
    public function setLno($Lno): void
    {
        $this->Lno = $Lno;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getRanswer()
    {
        return $this->ranswer;
    }

    /**
     * @param mixed $ranswer
     */
    public function setRanswer($ranswer): void
    {
        $this->ranswer = $ranswer;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function setWithoutItem($Lno, $question, $ranswer)
    {
        $this->Lno = $Lno;
        $this->question = $question;
        $this->ranswer = $ranswer;
    }

    public function addQuiz()
    {
        return $qid = DB::table('QuizInfo')->insertGetId(['Lno'=>$this->Lno, 'Title'=>$this->question, 'Ranswer'=>$this->ranswer]);
    }

    public function addQuizItem($qid)
    {
        for ($i = 0; $i < count($this->items); $i++){
            DB::table('QuizChoice')->insert([
                'Qid' => $qid,
                'Cno' => $i + 1,
                'Content' => $this->items[$i]
            ]);
        }
        return "Success";
    }

    public function showQuiz($lno){
        $qid = DB::table('QuizInfo')->where('Lno', '=', $lno)->pluck('Qid');
        return DB::table('QuizChoice')->select()->where('Qid', '=', $qid)->get();
    }

    public function solveQuiz($qid,$answer,$uid){
        DB::table('QuizAnswer')->insert([
            'Qid' => $qid,
            'Uid' => $uid,
            'Choice' => $answer
        ]);

        $ranswer = DB::table('QuizInfo')->where('Qid', '=', $qid)->pluck('Ranswer');
        
        if($ranswer[0] == $answer){
            return 1;
        } else {
            return 0;
        }
    }
}