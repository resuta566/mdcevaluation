<?php 
    namespace app\models;
    
    use Yii;
    use yii\base\Model;
    use app\models\Login;
    
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
        
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
        
        public function findPasswords($attribute, $params){
            $user = \app\models\User::find()->where([
                'id'=>Yii::$app->user->identity->id
            ])->one();
            $password = $user->password;
            $user = new \app\models\User;
            $old_password = $user->setPassword($this->oldpass);
            print_r($old_password);
            if($password!=$old_password)
            {
                $this->addError($attribute,'Old password is incorrect');
                die();
            }
            
        }
        
        public function attributeLabels(){
            return [
                'oldpass'=>'Old Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Repeat New Password',
            ];
        }
    }