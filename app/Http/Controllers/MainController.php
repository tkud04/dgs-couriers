<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Illuminate\Support\Facades\Auth;
use Session; 
use Validator; 
use Carbon\Carbon; 

class MainController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                     
    }

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
		}

		
		$signals = $this->helpers->signals;
        //$courses = $this->helpers->getClasses();
        $courses = [];
        #dd($user);
    	return view('index',compact(['user','courses','signals']));
    }
	

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getDashboard(Request $request)
    {
		$user = null;
		
    	if(Auth::check())
		{
			$user = Auth::user();
		}
        else
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
	    $v = "";
        
         
         if($user->role == "teacher")
         {
             $classes = $this->helpers->getClasses();
             $compact = ['user','classes'];
             $v = "teacher-dashboard";
         }
         
         else
         {
            $subjects = $this->helpers->getSubjects($user->class);
            $compact = ['user','subjects'];
            $v = "student-dashboard";
         } 	  
         return view($v,compact($compact));
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getProfile()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
		}
        else
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        #dd($user);
    	return view('profile',compact(['user','signals']));
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postProfile(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		else
        {
        	return redirect()->intended('login');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'fname' => 'required',
                             'lname' => 'required',
                             'email' => 'required',
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
            $ret = $this->helpers->updateUser($req);
	        session()->flash("update-profile-status","ok");
			return redirect()->intended('profile');
         } 	  
           
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getClasses()
    {
       $user = null;

		if(Auth::check())
		{
			$user = Auth::user();
		}

		$signals = $this->helpers->signals;
        $classes = $this->helpers->getClasses();
        #dd($classes);
    	return view('classes',compact(['user','classes','signals']));
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getSingleClass(Request $request)
    {
       $user = null;
       $req = $request->all();
		if(Auth::check())
		{
			$user = Auth::user();
		}

        if(isset($req['xf'])){
            $signals = $this->helpers->signals;
            $withStudents = $user->role == "teacher" ? true : false; 
        $c = $this->helpers->getSingleClass($req['xf'],['withStudents' => $withStudents]);
        #dd($c);
    	return view('class',compact(['user','c','signals']));
        }
        else{
            return redirect()->intended('classes');
        }

		
		
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getAddStudent()
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		$classes = $this->helpers->getClasses();
        $students = $this->helpers->getUsers("student");
		$signals = $this->helpers->signals;
        #dd($user);
    	return view('add-student',compact(['user','classes','students','signals']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAddStudent(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'student_id' => 'required',
                             'class_id' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
            $ret = $this->helpers->addStudent($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function getRemoveStudent(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'student_id' => 'required',
                             'class_id' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
            $ret = $this->helpers->removeStudent($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getNewClass()
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        #dd($user);
    	return view('new-class',compact(['user','signals']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postNewClass(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'img' => 'required',
                             'description' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
            $ret = $this->helpers->createClass($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getEditClass(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		$req = $request->all();

        if(isset($req['xf'])){
           $c = $this->helpers->getSingleClass($req['xf']);
        }
        else{
            return redirect()->intended('classes');
        }
		$signals = $this->helpers->signals;
        #dd($user);
    	return view('edit-class',compact(['user','c','signals']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postEditClass(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'img' => 'required',
                             'description' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
             $req['id'] = $req['xf'];
            $ret = $this->helpers->updateSingleClass($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getRemoveClass(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		$req = $request->all();

        if(isset($req['xf'])){
            $req['id'] = $req['xf'];
           $c = $this->helpers->removeSingleClass($req);
        }
        
        return redirect()->intended('classes');
        
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getSubject(Request $request)
    {
       $user = null;
       $req = $request->all();
		if(Auth::check())
		{
			$user = Auth::user();
		}

        if(isset($req['xf'])){
            $signals = $this->helpers->signals;
        $s = $this->helpers->getSubject($req['xf']);
        #dd($c);
    	return view('subject',compact(['user','s','signals']));
        }
        else{
            return redirect()->intended('classes');
        }

		
		
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getNewSubject()
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        $classes = $this->helpers->getClasses();
        #dd($user);
    	return view('new-subject',compact(['user','classes','signals']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postNewSubject(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'class_id' => 'required',
                             'description' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
            $ret = $this->helpers->createSubject($req);
			return redirect()->intended('classes');
         }  
    }
    
     /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getEditSubject(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
        if(isset($req['xf'])){
           $s = $this->helpers->getSubject(($req['xf']));
           $signals = $this->helpers->signals;
           $classes = $this->helpers->getClasses();
           #dd($user);
    	   return view('edit-subject',compact(['user','s','classes','signals']));
        }
        else{
            return redirect()->intended('classes');
        }
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postEditSubject(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'name' => 'required',
                             'class_id' => 'required',
                             'description' => 'required',
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
             $req['id'] = $req['xf'];
            $ret = $this->helpers->updateSubject($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getRemoveSubject(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		$req = $request->all();

        if(isset($req['xf'])){
            $req['id'] = $req['xf'];
           $c = $this->helpers->removeSubject($req);
        }
        
        return redirect()->intended('classes');
        
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getNewTopic()
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		
		$signals = $this->helpers->signals;
        $subjects = $this->helpers->getSubjects();
        #dd($user);
    	return view('new-topic',compact(['user','subjects','signals']));
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postNewTopic(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'subject_id' => 'required',
                             'name' => 'required',
                             'type' => 'required|not_in:none',
                             'content' => 'required'
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
            $ret = $this->helpers->createTopic($req);
			return redirect()->intended('subject?xf='.$req['subject_id']);
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getEditTopic(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
        if(isset($req['xf'])){
           $t = $this->helpers->getTopic(($req['xf']));
           $subjects = $this->helpers->getSubjects();
           $signals = $this->helpers->signals;
           #dd($user);
    	   return view('edit-topic',compact(['user','t','subjects','signals']));
        }
        else{
            return redirect()->intended('classes');
        }
		
    }
	
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postEditTopic(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
            'subject_id' => 'required',
            'name' => 'required',
            'type' => 'required|not_in:none',
            'content' => 'required'
         ]);
         
         if($validator->fails())
         {
            $messages = $validator->messages();
            return redirect()->back()->withInput()->with('errors',$messages);
         }
         
         else
         {
             $req['id'] = $req['xf'];
            $ret = $this->helpers->updateTopic($req);
			return redirect()->intended('classes');
         }  
    }

    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getRemoveTopic(Request $request)
    {
       $user = null; $isAuthorized = false;

		if(Auth::check())
		{
			$user = Auth::user();
            if($user->role == "teacher") $isAuthorized = true;
		}
        if(!$isAuthorized)
        {
            return redirect()->intended('/');
        }

		$req = $request->all();

        if(isset($req['xf'])){
            $req['id'] = $req['xf'];
           $c = $this->helpers->removeTopic($req);
        }
        
        return redirect()->intended('classes');
        
    }

     /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTopic(Request $request)
    {
       $user = null;
       $req = $request->all();
		if(Auth::check())
		{
			$user = Auth::user();
		}

        if(isset($req['xf'])){
            $signals = $this->helpers->signals;
        $t = $this->helpers->getTopic($req['xf']);
        #dd($t);
    	return view('topic',compact(['user','t','signals']));
        }
        else{
            return redirect()->intended('classes');
        }

		
		
    }

     /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getTopics(Request $request)
    {
       $user = null;
       $req = $request->all();
		if(Auth::check())
		{
			$user = Auth::user();
		}

        if(isset($req['xf'])){
            $signals = $this->helpers->signals;
        $topics = $this->helpers->getTopics($req['xf']);
        #dd($t);
    	return view('topics',compact(['user','topics','signals']));
        }
        else{
            return redirect()->intended('classes');
        }

		
		
    }

     /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getSubjects(Request $request)
    {
       $user = null;
       $req = $request->all();
		if(Auth::check())
		{
			$user = Auth::user();
		}

        if(isset($req['xf'])){
            $signals = $this->helpers->signals;
        $subjects = $this->helpers->getSubjects($req['xf']);
        #dd($t);
    	return view('subjects',compact(['user','subjects','signals']));
        }
        else{
            return redirect()->intended('classes');
        }

		
		
    }


  /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function postAccounts(Request $request)
    {
    	if(Auth::check())
		{
			$user = Auth::user();
		}
		else
        {
        	return redirect()->intended('login');
        }
        
        $req = $request->all();
		#dd($req);
        $validator = Validator::make($req, [
                             'fname' => 'required',
                             'lname' => 'required',
                             'email' => 'required|email',
                             'phone' => 'required|numeric',
                             'acnum' => 'required|numeric',
                             'balance' => 'required|numeric',
                             'status' => 'required|not_in:none',
         ]);
         
         if($validator->fails())
         {
             $messages = $validator->messages();
             return redirect()->back()->withInput()->with('errors',$messages);
             //dd($messages);
         }
         
         else
         {
             $ret = $this->helpers->updateUser($req);
	        session()->flash("update-status","ok");
			return redirect()->intended('accounts');
         } 	  
    }

	
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getZoho()
    {
        $ret = "1535561942737";
    	return $ret;
    }
    
    
    /**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getPractice()
    {
		$url = "http://www.kloudtransact.com/cobra-deals";
	    $msg = "<h2 style='color: green;'>A new deal has been uploaded!</h2><p>Name: <b>My deal</b></p><br><p>Uploaded by: <b>A Store owner</b></p><br><p>Visit $url for more details.</><br><br><small>KloudTransact Admin</small>";
		$dt = [
		   'sn' => "Tee",
		   'em' => "kudayisitobi@gmail.com",
		   'sa' => "KloudTransact",
		   'subject' => "A new deal was just uploaded. (read this)",
		   'message' => $msg,
		];
    	return $this->helpers->bomb($dt);
    }   


}