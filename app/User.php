<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\projectInvitation as Invitation;
use App\Project;
use App\Notification;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function social_friends() {
        return $this->hasMany(SocialFriend::class);
    }

    public function social()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function requests() 
    {
        return $this->hasMany(Request::class);
    }

    public function getfbFriends()
    {
        $friendsFromTable = Auth::user()->social_friends()->with('User')->get();
        $counter = 0;
        $friends = [];
        for($i=0; $i<count($friendsFromTable); $i++) {
            $userObject = $this->where('provider_user_id', $friendsFromTable[$i]->friend_provider_id)->first();
            if(count($userObject)>0) {
                $friends[$i] = $userObject;
                $counter = $counter + 1;
            }
        }
        return $friends;
    }

    public function getAvatar()
    {
        return url('uploads/images/' . $this->avatar);
    }
    
    public function invitations ()
    {
        return $this->hasMany(projectInvitation::class);
    }
    public function projects ()
    {
        return $this->hasMany(Project::class);
    }

    public function invited ($user_id, $project_id)
    {
        $invitation = new Invitation();
        $check = $invitation->where('from_id', $this->id)
                            ->where('to_id', $user_id)
                            ->where('project_id', $project_id)->first();
        if(count($check)>0) {
            return $check;
        }else{
            return [];
        }
    }

    public function invitings ($project_id)
    {
        $temps = Invitation::where('project_id', $project_id)->where('from_id', $this->id)->get();
        $users = [];
        if(count($temps)>0) {
            for($i=0; $i<count($temps); $i++) {
                $users[$i] = $this->find($temps[$i]->to_id);
            }
        }
        return $users;
    }
    public function hasInvitationFrom ()
    {
        
    }

    public function inviteToggle ($user, $projectID)
    {
        $invited = $this->invited($user->id, $projectID);
        if($invited) {
             $invited->delete();
        }else{
            $invitation = new Invitation();
            $invitation->project()->associate(Project::find($projectID));
            $invitation->toUser()->associate($user);
            $invitation->fromUser()->associate(Auth::user());
            $invitation->save();
            $text = $this->fname . ' has added you to a project so you can rate.';
            $url = '/rate/professional/' . $this->id;
            $user->newNotification($user->id, $this->id, $text, $url);
        }
    }

    public function notifications ()
    {
        return $this->hasMany(Notification::class);
    }

    public function newNotification ($user_id, $from_id, $text, $url)
    {
        $notification = new Notification([
            'from_id' => $from_id,
            'state' => 1,
            'later' => 0,
            'text' => $text,
            'url' => $url
        ]);
        $notification->user()->associate(User::find($user_id));
        $notification->save();
    }

    public function getNotifications ()
    {
        $notification = Auth::user()->notifications()->where('state', 1)->where('later', 0)->first();
        if ($notification) {
            notify()->flash($notification->text, 'success', [
                'url' => $notification->url,
                'id' => $notification->id,
            ]);
        }
    }
}
