<?php

session_start();

//세션 변수 해제
session_unset();
//session_destroy() 함수는 세션 파일을 삭제하지만 세션 ID 값이 있는 쿠키는 여전히 남아았음
//setcookie()함수를 이용하여 세션 ID가 저장된 쿠키를 강제로 만료시키는것
if (ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time()-42000,
        $params["path"], $params["domain"],
        $params["secure"],$parms["httponly"]
    );
}
//세션 파일 및 브라우저 쿠키 삭제
session_destroy();
?>
<script>
    alert("You've been logged out");
    location.replace('index.php')
</script>