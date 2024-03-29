<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /*
    | -------------------------------------------------------------------------
    | Hooks
    | -------------------------------------------------------------------------
    | This file lets you define "hooks" to extend CI without hacking the core
    | files.  Please see the user guide for info:
    |
    |	https://codeigniter.com/user_guide/general/hooks.html
    |
    */


    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : pre_system
    | -------------------------------------------------------------------------
    | 시스템 작동초기,
    | 벤치마크와 후킹클래스들만 로드된 상태로서, 라우팅을 비롯한 어떤 다른 프로
    | 세스도 진행되지않은 상태
    |
    */
    $hook['pre_system'][] = array(
    );

    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : pre_controller
    | -------------------------------------------------------------------------
    | 컨트롤러가 호출되기 직전,
    | 모든 기반클래스(base classes), 라우팅 그리고 보안점검이 완료된 상태
    |
    */

    // 요청 상세정보 로그 출력
    $hook['post_controller_constructor'][] = [
        'class'    => 'Request_log',
        'function' => 'write_log',
        'filename' => 'Request_log.php',
        'filepath' => 'hooks'
    ];

    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : post_controller_constructor
    | -------------------------------------------------------------------------
    | 컨트롤러가 인스턴스화 된 직후,
    | 사용준비가 완료된 상태로 인스턴스화 된 후 메소드들이 호출되기 직전
    |
    */

    // 사이트 언어셋 상수 설정
    $hook['post_controller_constructor'][] = [

    ];

    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : post_controller
    | -------------------------------------------------------------------------
    | 컨트롤러가 완전히 수행된 직후
    |
    */

    $hook['post_controller'][] = [
        'class'    => 'Request_log',
        'function' => 'query_log',
        'filename' => 'Request_log.php',
        'filepath' => 'hooks'
    ];



    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : post_system
    | -------------------------------------------------------------------------
    | 렌더링된 페이지가 브라우저로 보내진 직후
    |
    */

    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : display_override
    | -------------------------------------------------------------------------
    | _display() 함수를 재정의.
    | 최종적으로 브라우저에 페이지를 전송할 때 사용되며. 사용자가 정의한 display
    | 방법을 사용할 수 있음.
    |
    | 주의 : CI 부모객체(superobject)를 $this->CI = &get_instance()로 호출하여
    |        사용한 후에 최종데이터 작성은 $this->CI->output->get_output() 함수를
    |        호출하여 할 수 있음
    |
    */

    /*
    | -------------------------------------------------------------------------
    | 후크 포인트 : cache_override
    | -------------------------------------------------------------------------
    | _display_cache() 함수를 재정의
    | 사용자가 정의한 display cache를 적용할 수 있음.
    |
    */
?>
