<?php

namespace App\Http\Controllers;

use App\Cloud;
use App\Lesson;
use App\Subject;
use App\Quiz;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController
{
    private $request = null;

    /**
     * @var Cloud
     */
    private $Cloud = null;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * FormData에서부터 비디오를 받아옵니다.
     *
     * @return bool|string
     */
    public function uploadVideo($Cid)
    {
        if ($this->request->hasFile('video'))
        {
            $file = $this->request->file('video');

            $path = $file->move('video', uniqid().$file->getClientOriginalName())->getFilename();

            $this->Cloud = new Cloud($file->getClientOriginalName(), $path, $Cid, 'student');
            return $this->Cloud->insertDB();

        } else {
            return false;
        }
    }



    public function AddLesson() {
        // Get Body Parameter
        $UserId = $this->request->input('uid');
        $ClassId = $this->request->input('cid');
        $Title = $this->request->input('title');
        $Subject = $this->request->input('subject');
        $Grade = $this->request->input('grade');
        $Semester = $this->request->input('semester');
        $Unit = $this->request->input('unit');
        $Explain = $this->request->input('explain');
        $Link = $this->request->input('link');
        if($Link)
        {
            $this->Cloud = new Cloud($Title, $Link, $ClassId, 'student');
            $this->Cloud->insertDB();
        }
        else if (!$this->uploadVideo($ClassId)){
            return "video not found";
        }


        $Sub = new Subject($Subject);
        $Sub->addYearSubjectDB($Grade, $Semester);

        $lesson = new Lesson();
        $lesson->setAll($this->Cloud, $ClassId, $Title, $Explain, $Sub, $Unit, $UserId);
        $Lno = $lesson->insertDB();
        return response()->json(['Lno' => $Lno], Response::HTTP_OK);
    }

    public function getLessonList() {
        $Cid = $this->request->query('cid');
        return Lesson::getLessonList($Cid);
    }

    public function deleteClassList(){
        $Lno = $this->request->query('lno');
        $lesson = new Lesson();
        $lesson->setLno($Lno);
        return $lesson->deleteLessonDB();
    }

    public function addQuiz(){
        $Lno = $this->request->input('lno');
        $question = $this->request->input('question');
        $item = $this->request->input('item.*');
        $ranswer = $this->request->input('ranswer');
        $type = $this->request->input('type');

        $quiz = new Quiz();
        $quiz->setWithoutItem($Lno, $question,$ranswer,$type);
        $qid = $quiz->addQuiz();
        $quiz->setItems($item);
        return $quiz->addQuizItem($qid);
    }

    public function showQuiz(){
        $lno = $this->request->query('lno');
        $type = $this->request->query('type');

        $quiz = new Quiz();
        return $quiz->showQuiz($lno,$type);
    }

    public function solveQuiz(){
        $qid = $this->request->input('qid');
        $answer = $this->request->input('answer');
        $uid = $this->request->input('uid');

        $quiz = new Quiz();
        return $quiz->solveQuiz($qid,$answer,$uid);
    }
}