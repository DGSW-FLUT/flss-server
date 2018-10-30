<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ClasstingRequest;
use App\iDBModel;

class UserModel
{

    /**
     * User Identifier Number
     * 유저 ID
     * @var string
     */
    protected $id;

    /**
     * User Name
     * 유저 이름
     * @var string
     */
    protected $name;

    /**
     *
     * User Profile Image url
     * 유저 이미지 url
     * @var string
     */
    protected $profile_image;

    /**
     *
     * User Role
     * 유저 직책
     * @var string
     */
    protected $role;

    /**
     *
     * User Email
     * 유저 이메일
     * @var string
     */
    protected $email;

    /**
     * userModel setAll.
     * @param string $id
     * @param string $name
     * @param string $profile_image
     * @param string $role
     * @param string $email
     */
    public function setAll(string $id, string $name, string $profile_image, string $role, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->profile_image = $profile_image;
        $this->role = $role;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getProfileImage(): string
    {
        return $this->profile_image;
    }

    /**
     * @param string $profile_image
     */
    public function setProfileImage(string $profile_image): void
    {
        $this->profile_image = $profile_image;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setFromDB($id)
    {
        $data = DB::table("User")->select()->where('Cid', '=', $id)->get()->toArray();

        print_r($data);
        if ($data && $data[0]) {
            $this->setAllFromArray($data[0]);

            return true;
        }
        return false;
    }

    /**
     * UserModel setFromArray
     * @param array|object $user
     */
    public function setAllFromArray($user)
    {
        if (is_object($user))
            $user = get_object_vars($user);

        if (isset($user['id']))
            $this->id = $user['id'];
        else
            $this->id = $user['Cid'];

        if (isset($user['name']))
            $this->name = $user['name'];
        else
            $this->name = $user['Name'];

        if (isset($user['role']))
            $this->role = $user['role'];
        else
            $this->role = $user['Role'];

        if (isset($user['profile_image']))
            $this->profile_image = $user['profile_image'];
        else
            $this->profile_image = $user['Profile'];

        if (isset($user['email']))
            $this->email = $user['email'];
        else
            $this->email = $user['Email'];
    }

    /**
     * 유저 배열에서 유저 모델의 배열로 변환합니다.
     * @param mixed $user 컬랙션
     * @return Object
     */
    public static function getUserFromObjectArray($user)
    {
        $u = new UserModel();
        $u->setAllFromArray($user);
        $user = $u;

        return $user;
    }


    /**
     * 해당 model을 DB에 넣습니다.
     * @return bool
     */
    public function insertDB()
    {
        DB::table('User')->updateOrInsert(['Cid' => $this->getId()],[
            'Cid' => $this->getId(),
            'Name' => $this->getName(),
            'Email' => $this->getEmail(),
            'Profile' => $this->getProfileImage(),
            'Role' => $this->getRole()
        ]);

        return DB::table('User')->where(['Cid' => $this->getId()])->pluck('Uid')[0];
    }

    public function toArray($uid): array
    {
        return ['id' => $this->id, 'uid' => $uid, 'name' => $this->name, 'email' => $this->email, 'profile_image' => $this->profile_image, 'role' => $this->role];
    }
}

class UserInfo extends Model
{
    public function getUser($token)
    {
        $request = new ClasstingRequest($token);
        $datas = $request->Ting_Get('/v2/users/me');
        if (!$datas)
            return "Invalid Token";
        $models = UserModel::getUserFromObjectArray($datas);

        $uid = $models->insertDB();
        return $models->toArray($uid);
    }
}
