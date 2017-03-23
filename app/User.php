<?php

namespace App;

use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\projectInvitation as Invitation;
use App\Project;
use App\Notification;
use App\Rate;

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

    public function ratesSortedByFriends ($category)
    {
        $friendships = Auth::user()->getAllFriendships();
        $friends = [];
        foreach ($friendships as $friendship) {
            if($friendship->sender_id != Auth::id()) {
                $user = User::find($friendship->sender_id);
                $friends[] = $user;
            }
            if($friendship->recipient_id != Auth::id()) {
                $user = User::find($friendship->recipient_id);
                $friends[] = $user;
            }
        }
        $final_rates = [];
        for ($i=0; $i < count($friends) ; $i++) {
            $rates = Auth::user()->rates()->whereFromId($friends[$i]->id)->get()->sortByDesc('updated_at');
            $personalRatesFormed = [];
            $socialRatesFormed = [];
            if(count($rates) > 0) {
                foreach ($rates as $rate) {
                    if($rate->category == 'social') {
                        $socialRatesFormed[] = array(
                            'traitName' => $rate->getTraitName($rate->rate_trait_id),
                            'rate' => $rate->rate,
                            'review' => $rate->review,
                            'category' => $rate->category,
                            'updated_at' => $rate->updated_at,
                        );
                    }
                    if($rate->category == 'personal') {
                        $personalRatesFormed[] = array(
                            'traitName' => $rate->getTraitName($rate->rate_trait_id),
                            'rate' => $rate->rate,
                            'review' => $rate->review,
                            'category' => $rate->category,
                            'updated_at' => $rate->updated_at,
                        );
                    }
                }
                if($category == 'social') {
                    if(count($socialRatesFormed)) {
                        $final_rates['social'][] = $socialRatesFormed;
                    }
                }else{
                    if(count($personalRatesFormed)) {
                        $final_rates['personal'][] = $personalRatesFormed;
                    }
                }
            }
        }

        if($category == 'social') {
            if(isset($final_rates['social'])) {
                return $final_rates['social'];
            }
            return [];
        }

        if(isset($final_rates['personal'])) {
            return $final_rates['personal'];
        }
        return [];
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
            $url = '/rate/project/' . $projectID;
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
