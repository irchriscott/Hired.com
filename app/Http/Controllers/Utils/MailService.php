<?php 

namespace App\Http\Controllers\Utils;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Notification;

class MailService
{
    static function sendJobSuggestion($suggestion, $profile){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'irchristianscott@gmail.com';
            $mail->Password = '323639371998';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('irchristianscott@gmail.com', 'Hired.com');
            $mail->addAddress($suggestion->job->user->email, $suggestion->job->user->name);

            //Attachments
            $mail->addAttachment('C:\\xampp\\htdocs\\hired.com\\storage\\app\\public\\profile_cvs\\' . $profile->cv_document, strtoupper($profile->user->username) . '_CURRICULUM_VITAE');

            //Content
            $mail->isHTML(true);
            $mail->Subject = '[Hired.com] New Suggestion For Your ' . ucfirst($suggestion->job->job_type);
            $mail->Body = MailService::jobTemplate($suggestion, $profile);

            $mail->send();

        } catch(Exception $e){
            session()->flash('error', $mail->ErrorInfo);
        }
    }

    static function jobTemplate($suggestion, $profile){
        return '
            <head>
            <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
            </head>
            <body style="background: #eeeeee !important; padding:30px 0 !important;">
                <section style="font-family:Avenir, Century Gothic; background: #eeeeee !important;; width: 100%; margin:30px 0 !important; color: #777777;">
                    <div style="background: #ffffff !important; width: 65%; margin: 30px auto !important; padding: 20px;">
                        <h1 style="font-family:Avenir, Century Gothic; margin: 0; font-weight: normal; border-bottom: 1px solid rgba(0, 0, 0, .1); padding-bottom: 15px;"><span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></h1>
                        <p style="font-family:Avenir, Century Gothic; margin-top: 20px;">Hi ' . $suggestion->job->user->name . ' !</p>
                        <p style="font-family:Avenir, Century Gothic;">We wanted to inform you that you have received a suggestion to your job <a href="' . route('job.show', [$suggestion->job->id, $suggestion->job->uuid]) . '" style="text-decoration: none; color: #908ced; font-family:Avenir, Century Gothic;"><strong>' . $suggestion->job->title . '</strong></a> of position <strong>' . $suggestion->job->position . '</strong> from <a href="' . route('user.about', $profile->user->username) . '" style="text-decoration: none; color: #908ced; font-family:Avenir, Century Gothic;"><strong> '. $profile->user->name .' @' . $profile->user->username . ' </strong></a> Profile here bellow </p>
                        <div style="font-family:Avenir, Century Gothic; padding: 15px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 3px; margin-top: 20px; display: block; position: relative">
                            <div style="float: left; width: 200px; height: auto; margin-right: 15px;">
                                <img src="' . $profile->images[0]->getImagePath() . '" alt="'. $profile->title .'" style="width:100%;" />
                            </div>
                            <div style="margin-left: 215px">
                                <h2 style="font-family:Avenir, Century Gothic; font-weight: normal; margin: 0;">' . $profile->title . '</h2>
                                <p style="font-family:Avenir, Century Gothic; margin-top: 5px; font-size: 14px;">' . $profile->about . '</p>
                                <div style="margin-top: -7px;">
                                ' . MailService::getBadges($profile->preferences) . '
                                </div>
                                <div style="margin-top: 10px;">
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M486.4 972.8c-4.283 0-8.566-1.074-12.434-3.222-4.808-2.67-119.088-66.624-235.122-171.376-68.643-61.97-123.467-125.363-162.944-188.418-50.365-80.443-75.901-160.715-75.901-238.584 0-148.218 120.582-268.8 268.8-268.8 50.173 0 103.462 18.805 150.051 52.952 27.251 19.973 50.442 44.043 67.549 69.606 17.107-25.565 40.299-49.634 67.55-69.606 46.589-34.147 99.878-52.952 150.050-52.952 148.218 0 268.8 120.582 268.8 268.8 0 77.869-25.538 158.141-75.901 238.584-39.478 63.054-94.301 126.446-162.944 188.418-116.034 104.754-230.314 168.706-235.122 171.376-3.867 2.149-8.15 3.222-12.434 3.222zM268.8 153.6c-119.986 0-217.6 97.614-217.6 217.6 0 155.624 120.302 297.077 221.224 388.338 90.131 81.504 181.44 138.658 213.976 158.042 32.536-19.384 123.845-76.538 213.976-158.042 100.922-91.261 221.224-232.714 221.224-388.338 0-119.986-97.616-217.6-217.6-217.6-87.187 0-171.856 71.725-193.314 136.096-3.485 10.453-13.267 17.504-24.286 17.504s-20.802-7.051-24.286-17.504c-21.456-64.371-106.125-136.096-193.314-136.096z"></path></svg> ' . $profile->likesCount() . ' Likes</span>
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block; text-align: center;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M793.598 972.8c-4.205 0-8.422-1.034-12.258-3.126l-269.341-146.912-269.341 146.912c-8.598 4.691-19.118 4.061-27.098-1.613-7.981-5.677-12.022-15.41-10.413-25.069l49.034-294.206-195.483-195.485c-6.781-6.781-9.203-16.782-6.277-25.914s10.712-15.862 20.17-17.438l294.341-49.058 122.17-244.339c4.336-8.674 13.2-14.152 22.898-14.152s18.562 5.478 22.898 14.152l122.17 244.339 294.341 49.058c9.459 1.576 17.243 8.307 20.17 17.438s0.504 19.133-6.277 25.914l-195.483 195.485 49.034 294.206c1.61 9.659-2.434 19.392-10.413 25.069-4.419 3.144-9.621 4.739-14.84 4.739zM512 768c4.219 0 8.437 1.042 12.259 3.126l235.445 128.426-42.557-255.344c-1.36-8.155 1.302-16.464 7.15-22.309l169.626-169.626-258.131-43.022c-8.080-1.346-15.027-6.477-18.69-13.803l-105.102-210.205-105.102 210.205c-3.664 7.326-10.61 12.458-18.69 13.803l-258.131 43.022 169.624 169.626c5.846 5.845 8.509 14.155 7.15 22.309l-42.557 255.344 235.446-128.426c3.821-2.085 8.040-3.126 12.259-3.126z"></path></svg> ' . $profile->getAverageReview() . ' Stars</span>
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block; text-align: right;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M25.6 972.8c-11.507 0-21.6-7.677-24.67-18.766s1.634-22.864 11.501-28.784c86.57-51.942 122.485-127.414 135.218-162.755-94.088-72.048-147.648-171.746-147.648-276.094 0-52.704 13.23-103.755 39.323-151.736 24.902-45.794 60.406-86.806 105.526-121.899 91.504-71.17 212.802-110.365 341.55-110.365s250.046 39.195 341.552 110.366c45.118 35.093 80.624 76.104 105.526 121.899 26.091 47.979 39.322 99.030 39.322 151.734 0 52.702-13.23 103.755-39.322 151.736-24.902 45.794-60.408 86.806-105.526 121.899-91.506 71.17-212.803 110.365-341.552 110.365-52.907 0-104.8-6.627-154.437-19.707-21.974 14.637-63.040 40.605-112.086 65.005-76.163 37.89-141.528 57.102-194.277 57.102zM486.4 153.6c-239.97 0-435.2 149.294-435.2 332.8 0 92.946 51.432 182.379 141.107 245.368 8.797 6.178 12.795 17.194 10.013 27.576-5.984 22.325-26.363 83.597-80.878 142.734 66.659-23.341 138.424-63.832 191.434-100.286 6.296-4.328 14.197-5.621 21.544-3.52 48.558 13.888 99.691 20.928 151.981 20.928 239.97 0 435.2-149.294 435.2-332.8s-195.23-332.8-435.2-332.8z"></path></svg> ' . $profile->reviewsCount() . ' Reviews</span>
                                </div>
                                <div style="display: block;">
                                    <img src="' . $profile->user->getProfileImage() . '" alt="' . $profile->user->username . '" style="height: 30px; border-radius: 50%; margin-right: 10px; float: left;" />
                                    <p style="font-family:Avenir, Century Gothic; margin: 0; margin-top: 5px; display: block; font-size: 13px; padding-top: 6px;"><a href="'. route('user.about', $profile->user->username) .'" style="color: #777777; text-decoration: none; font-family: Avenir, Century Gothic;">' . $profile->user->name . ' @' . $profile->user->username . '</a></p>
                                </div>
                            </div>
                        </div>
                        <p style="font-family:Avenir, Century Gothic; display: block; padding: 10px; background: linear-gradient(#908ced, #b56fe8); text-align: center; border-radius: 4px; margin-top: 10px;"><a href="' . route('user.profile.show', [$profile->id, $profile->uuid]) . '" style="color: #ffffff; font-size: 17px; text-decoration: none; text-transform: uppercase; font-family:Avenir, Century Gothic;">View Full Profile</a></p>
                        <p style="font-family:Avenir, Century Gothic; margin-bottom: 0; margin-top: 30px; font-size: 12px;">Send by the team from <span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></p>
                    </div>
                </section>
            </body>
        ';
    }

    static function sendHireJob($job, $profile){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'irchristianscott@gmail.com';
            $mail->Password = '323639371998';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('irchristianscott@gmail.com', 'Hired.com');
            $mail->addAddress($profile->user->email, $profile->user->name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = '[Hired.com] New ' . ucfirst($job->job_type) . ' For Your ';
            $mail->Body = MailService::profileTemplate($job, $profile);

            $mail->send();

        } catch(Exception $e){
            session()->flash('error', $mail->ErrorInfo);
        }
    }

    static function profileTemplate($job, $profile){
        return '
            <head>
            <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
            </head>
            <body style="background: #eeeeee !important; padding:30px 0 !important;">
                <section style="font-family:Avenir, Century Gothic; background: #eeeeee !important;; width: 100%; margin:30px 0 !important; color: #777777;">
                    <div style="background: #ffffff !important; width: 65%; margin: 30px auto !important; padding: 20px;">
                        <h1 style="font-family:Avenir, Century Gothic; margin: 0; font-weight: normal; border-bottom: 1px solid rgba(0, 0, 0, .1); padding-bottom: 15px;"><span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></h1>
                        <p style="font-family:Avenir, Century Gothic; margin-top: 20px;">Hi ' . $profile->user->name . ' !</p>
                        <p style="font-family:Avenir, Century Gothic;">We wanted to inform you that you have received a suggestion  for a ' . $job->job_type . ' <a href="' . route('job.show', [$job->id, $job->uuid]) . '" style="text-decoration: none; color: #908ced; font-family:Avenir, Century Gothic;"><strong>' . $job->title . '</strong></a> of position <strong>' . $job->position . '</strong> from <a href="' . route('user.about', $job->user->username) . '" style="text-decoration: none; color: #908ced; font-family:Avenir, Century Gothic;"><strong> '. $job->user->name .' @' . $job->user->username . ' </strong></a> Profile here bellow </p>
                        <div style="font-family:Avenir, Century Gothic; padding: 15px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 3px; margin-top: 20px; display: block; position: relative">
                            <div style="float: left; width: 200px; height: auto; margin-right: 15px;">
                                <img src="' . $job->images[0]->getImagePath() . '" alt="'. $profile->title .'" style="width:100%;" />
                            </div>
                            <div style="margin-left: 215px">
                                <h2 style="font-family:Avenir, Century Gothic; font-weight: normal; margin: 0;">' . $job->title . '</h2>
                                <p style="font-family:Avenir, Century Gothic; margin-top: 5px; font-size: 14px;">' . $job->position . '</p>
                                <div style="margin-top: 6px; margin-bottom:6px;">
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 2); display: inline-block;"><strong>Salary : </strong> ' . $job->getSalary() . '</span>
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 2); display: inline-block; text-align: right;"><strong>Duration : </strong> ' . $job->getDuration() . '</span>
                                </div>
                                <div style="margin-top: -7px;">
                                ' . MailService::getBadges($job->preferences) . '
                                </div>
                                <div style="margin-top: 10px; padding-top:8px;">
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M486.4 972.8c-4.283 0-8.566-1.074-12.434-3.222-4.808-2.67-119.088-66.624-235.122-171.376-68.643-61.97-123.467-125.363-162.944-188.418-50.365-80.443-75.901-160.715-75.901-238.584 0-148.218 120.582-268.8 268.8-268.8 50.173 0 103.462 18.805 150.051 52.952 27.251 19.973 50.442 44.043 67.549 69.606 17.107-25.565 40.299-49.634 67.55-69.606 46.589-34.147 99.878-52.952 150.050-52.952 148.218 0 268.8 120.582 268.8 268.8 0 77.869-25.538 158.141-75.901 238.584-39.478 63.054-94.301 126.446-162.944 188.418-116.034 104.754-230.314 168.706-235.122 171.376-3.867 2.149-8.15 3.222-12.434 3.222zM268.8 153.6c-119.986 0-217.6 97.614-217.6 217.6 0 155.624 120.302 297.077 221.224 388.338 90.131 81.504 181.44 138.658 213.976 158.042 32.536-19.384 123.845-76.538 213.976-158.042 100.922-91.261 221.224-232.714 221.224-388.338 0-119.986-97.616-217.6-217.6-217.6-87.187 0-171.856 71.725-193.314 136.096-3.485 10.453-13.267 17.504-24.286 17.504s-20.802-7.051-24.286-17.504c-21.456-64.371-106.125-136.096-193.314-136.096z"></path></svg> ' . $job->likesCount() . ' Likes</span>
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block; text-align: center;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M793.598 972.8c-4.205 0-8.422-1.034-12.258-3.126l-269.341-146.912-269.341 146.912c-8.598 4.691-19.118 4.061-27.098-1.613-7.981-5.677-12.022-15.41-10.413-25.069l49.034-294.206-195.483-195.485c-6.781-6.781-9.203-16.782-6.277-25.914s10.712-15.862 20.17-17.438l294.341-49.058 122.17-244.339c4.336-8.674 13.2-14.152 22.898-14.152s18.562 5.478 22.898 14.152l122.17 244.339 294.341 49.058c9.459 1.576 17.243 8.307 20.17 17.438s0.504 19.133-6.277 25.914l-195.483 195.485 49.034 294.206c1.61 9.659-2.434 19.392-10.413 25.069-4.419 3.144-9.621 4.739-14.84 4.739zM512 768c4.219 0 8.437 1.042 12.259 3.126l235.445 128.426-42.557-255.344c-1.36-8.155 1.302-16.464 7.15-22.309l169.626-169.626-258.131-43.022c-8.080-1.346-15.027-6.477-18.69-13.803l-105.102-210.205-105.102 210.205c-3.664 7.326-10.61 12.458-18.69 13.803l-258.131 43.022 169.624 169.626c5.846 5.845 8.509 14.155 7.15 22.309l-42.557 255.344 235.446-128.426c3.821-2.085 8.040-3.126 12.259-3.126z"></path></svg> ' . $job->suggestionsCount() . ' Suggestions</span>
                                    <span style="font-family:Avenir, Century Gothic; width: calc((100% - 10px) / 3); display: inline-block; text-align: right;"><svg style="display: inline; width: 15px" viewBox="0 0 1024 1024"><path style="display: block;" d="M25.6 972.8c-11.507 0-21.6-7.677-24.67-18.766s1.634-22.864 11.501-28.784c86.57-51.942 122.485-127.414 135.218-162.755-94.088-72.048-147.648-171.746-147.648-276.094 0-52.704 13.23-103.755 39.323-151.736 24.902-45.794 60.406-86.806 105.526-121.899 91.504-71.17 212.802-110.365 341.55-110.365s250.046 39.195 341.552 110.366c45.118 35.093 80.624 76.104 105.526 121.899 26.091 47.979 39.322 99.030 39.322 151.734 0 52.702-13.23 103.755-39.322 151.736-24.902 45.794-60.408 86.806-105.526 121.899-91.506 71.17-212.803 110.365-341.552 110.365-52.907 0-104.8-6.627-154.437-19.707-21.974 14.637-63.040 40.605-112.086 65.005-76.163 37.89-141.528 57.102-194.277 57.102zM486.4 153.6c-239.97 0-435.2 149.294-435.2 332.8 0 92.946 51.432 182.379 141.107 245.368 8.797 6.178 12.795 17.194 10.013 27.576-5.984 22.325-26.363 83.597-80.878 142.734 66.659-23.341 138.424-63.832 191.434-100.286 6.296-4.328 14.197-5.621 21.544-3.52 48.558 13.888 99.691 20.928 151.981 20.928 239.97 0 435.2-149.294 435.2-332.8s-195.23-332.8-435.2-332.8z"></path></svg> ' . $job->commentsCount() . ' Comments</span>
                                </div>
                                <div style="display: block;">
                                    <img src="' . $job->user->getProfileImage() . '" alt="' . $job->user->username . '" style="height: 30px; border-radius: 50%; margin-right: 10px; float: left;" />
                                    <p style="font-family:Avenir, Century Gothic; margin: 0; margin-top: 5px; display: block; font-size: 13px; padding-top: 6px;"><a href="'. route('user.about', $job->user->username) .'" style="color: #777777; text-decoration: none; font-family: Avenir, Century Gothic;">' . $job->user->name . ' @' . $job->user->username . '</a></p>
                                </div>
                            </div>
                        </div>
                        <p style="font-family:Avenir, Century Gothic; display: block; padding: 10px; background: linear-gradient(#908ced, #b56fe8); text-align: center; border-radius: 4px; margin-top: 10px;"><a href="' . route('job.show', [$job->id, $job->uuid]) . '" style="color: #ffffff; font-size: 17px; text-decoration: none; text-transform: uppercase; font-family:Avenir, Century Gothic;">View Full ' . ucfirst($job->job_type) . '</a></p>
                        <p style="font-family:Avenir, Century Gothic; margin-bottom: 0; margin-top: 30px; font-size: 12px;">Send by the team from <span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></p>
                    </div>
                </section>
            </body>
        ';
    }

    static function getBadges($preferences){
        $badgesString = '';
        foreach($preferences as $pref){
            $badgesString .= '<span style="font-family:Avenir, Century Gothic; display: inline; padding: 5px 10px; margin-right: 5px; background: #EEEFFF; border-radius: 2px; font-size: 11px;">' . $pref->subcategory->name . '</span>';
        }
        return $badgesString;
    }

    static function statusUpdateMail($suggestion){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'irchristianscott@gmail.com';
            $mail->Password = '323639371998';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('irchristianscott@gmail.com', 'Hired.com');
            $mail->addAddress($suggestion->profile()->user->email, $suggestion->profile()->user->username);

            //Content
            $mail->isHTML(true);
            $mail->Subject = '[Hired.com] Update Suggestion Status';
            $mail->Body = MailService::suggestionUpdateTemplate($suggestion);

            $mail->send();
            return ['type' => 'success', 'text' => 'Suggestion '. strtoupper($suggestion->status) . ' !!!'];
        } catch(Exception $e){
            return ['type' => 'error', 'text' => $mail->ErrorInfo];
        }
    }

    static function suggestionUpdateTemplate($suggestion){
        return '
            <head>
            <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
            </head>
            <body style="background: #eeeeee !important; padding:30px 0 !important;">
                <section style="font-family:Avenir, Century Gothic; background: #eeeeee !important;; width: 100%; margin:30px 0 !important; color: #777777;">
                    <div style="background: #ffffff !important; width: 65%; margin: 30px auto !important; padding: 20px;">
                        <h1 style="font-family:Avenir, Century Gothic; margin: 0; font-weight: normal; border-bottom: 1px solid rgba(0, 0, 0, .1); padding-bottom: 15px;"><span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></h1>
                        <p style="font-family:Avenir, Century Gothic; margin-top: 20px;">Hi ' . $suggestion->profile()->user->name . ' !</p>
                        <p style="font-family:Avenir, Century Gothic;">We wanted to inform you that your suggestion posted on <a href="' . route('job.show', [$suggestion->job->id, $suggestion->job->uuid]) . '" style="text-decoration: none; color: #908ced;"><strong>' . $suggestion->job->title . '</strong></a> of position <strong>' . $suggestion->job->position . '</strong> of <a href="' . route('user.about', $suggestion->job->user->username) . '" style="text-decoration: none; color: #908ced;"><strong> '. $suggestion->job->user->name .' @' . $suggestion->job->user->username . ' </strong></a> has been <strong>' . strtoupper($suggestion->status) . '</strong></p>
                        <p style="font-family:Avenir, Century Gothic; margin-bottom: 0; margin-top: 30px; font-size: 12px;">Send by the team from <span style="color: #908ced;">Hired</span><span style="color: #b56fe8;">.com</span></p>
                    </div>
                </section>
            </body>
        ';
    }

    static function sendToSuggesters(Request $request, $job){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'irchristianscott@gmail.com';
            $mail->Password = '323639371998';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom($job->user->email, $job->user->name);
            foreach($job->suggestions as $suggestion){
                $mail->addAddress($suggestion->profile()->user->email, $suggestion->profile()->user->name);
                Notification::create([
                    'user_from_id' => $job->user->id,
                    'user_to_id' => $suggestion->profile()->user->id,
                    'ressource' => 'suggestion_mail',
                    'ressource_id' => $job->id
                ]);
            }
            $mail->addAddress($job->user->email, $job->user->name);

            //Attachments
            if($request->hasFile('file')){
                $filenameWithExt = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileToSend = 'attachment_' . $filename . '_' . time() . '.' . $extension;
                $path = $request->file('file')->storeAs('public/mails_attachments', $fileToSend); 
                $mail->addAttachment('C:\\xampp\\htdocs\\hired.com\\storage\\app\\public\\mails_attachments\\' . $fileToSend);
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $request->input('title');
            $mail->Body = $request->input('message');

            $mail->send();

        } catch(Exception $e){
            session()->flash('error', $mail->ErrorInfo);
        }
    }
}