<?php
class Core_Message {

    protected static $_instance = null;
    
    /**
     * 
     * @return \Core_Message
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new Core_Message();
        return self::$_instance;
    }
    
    /**
     * @desc showMessage
     * @param String $orderStatus
     * @param String $bankCode = ''
     * @return String Hien thong bao loi cho user
     */
    public function showMessage($orderStatus, $bankCode = '') {
        $errMsg = 'Phát sinh lỗi từ hệ thống, quý khách vui lòng thực hiện lại giao dịch.';
        if ($bankCode == '123PBIDV') {
            switch ($orderStatus) {
                case '7257':
                    $errMsg = 'Giao dịch không thành công do không tìm thấy thông tin số điện thoại của quý khách. Vui lòng liên hệ <b>BIDV</b> qua số <b>1800 1542</b> hoặc <b>(04)22 200 588</b> để được hỗ trợ.';
                    break;
                case '7232':
                    $errMsg = 'Ngân hàng không tìm thấy thông tin tài khoản của quý khách. Vui lòng liên hệ <b>BIDV</b> qua số <b>1800 1542</b> hoặc <b>(04)22 200 588</b> để được hỗ trợ.';
                    break;
                case '7231':
                    $errMsg = 'Thông tin thẻ không chính xác, xin vui lòng kiểm tra lại.';
                    break;
                case '7201':
                    $errMsg = 'Giao dịch không thực hiện được do số tiền giao dịch vượt quá hạn mức cho phép trong một lần giao dịch.';
                    break;
                case '7203':
                    $errMsg = 'Giao dịch không thực hiện được do tổng số tiền thanh toán trực tuyến trong ngày đã vượt quá hạn mức cho phép.';
                    break;
                case '7204':
                    $errMsg = 'Giao dịch tạm thời không thực hiện được do tổng số lần giao dịch thanh toán trực tuyến trong ngày đã vượt quá số lần cho phép.';
                    break;
                case '7213':
                    $errMsg = "Giao dịch không thực hiện được do thẻ/tài khoản chưa kích hoạt hoặc bị khóa.  Vui lòng liên hệ ngân hàng <b>BIDV</b> qua số <b>1800 1542</b> hoặc <b>(04)22 200 588</b> để được hỗ trợ.";
                    break;
                case '7202':
                    $errMsg = 'Giao dịch không thực hiện được do không đảm bảo điều kiện số dư tối thiểu trong tài khoản.';
                    break;
            }
        } else if ($bankCode == '123PEIB') {
        //} elseif (strcmp($bankCode, '123PEIB') == 1) {
            switch ($orderStatus) {
                case '7232':
                    $errMsg = 'Ngân hàng không tìm thấy thông tin tài khoản của quý khách. Vui lòng liên hệ <b>Eximbank</b> qua số <b>1900 54 54 74</b> hoặc <b>(08)39 15 15 15</b> để được hỗ trợ.';
                    break;
                case '7211':
                    $errMsg = 'Giao dịch không thực hiện được. Quý khách cần đăng ký dịch vụ <b>SMS Banking</b> và <b>Thanh toán trực tuyến</b> để thanh toán:<br> <b>+</b> Nếu chưa đăng ký <b>SMS Banking</b>, quý khách có thể làm theo <a href="http://www.eximbank.com.vn/vn/nganhangdientu_sms.aspx" target="_blank">hướng dẫn sau</a>.<br><b>+</b> Nếu đã đăng ký <b>SMS Banking</b>, quý khách có thể kích hoạt dịch vụ <b>Thanh toán trực tuyến</b> bằng cách:<br>- Nhắn tin theo cú pháp: <b>EIB ECOM [Số thẻ]</b> và gửi đến <b>8149</b>.<br>- Hoặc vào <a href="https://ebanking.eximbank.vn" target="_blank"><b>Internet Banking</b></a> để kích hoạt dịch vụ.';
                    break;
                case '7212':
                    $errMsg = 'Giao dịch không thực hiện được do dịch vụ <b>Thanh toán trực tuyến</b> của quý khách đang tạm khóa.
						Vui lòng liên hệ ngân hàng <b>Eximbank</b> qua số <b>1900 54 54 74</b>hoặc <b>(08)39 15 15 15</b> để được hỗ trợ.';
                    break;
                case '7231':
                    $errMsg = "Thông tin thẻ không chính xác, xin vui lòng kiểm tra lại.";
                    break;
                case '7201':
                    $errMsg = "Tài khoản của quý khách không đủ tiền để thanh toán";
                    break;
                case '7232':
                    $errMsg = "Ngân hàng không tìm thấy thông tin tài khoản của quý khách. Vui lòng liên hệ <b>Eximbank</b> qua số <b>1900 54 54 74</> hoặc <b>(08)39 15 15 15</b> để được hỗ trợ.";
                    break;
                case '7234':
                    $errMsg = "Giao dịch không thực hiện được do tài khoản thanh toán đã bị khóa. Vui lòng liên hệ ngân hàng <b>Eximbank</b> qua số <b>1900 54 54 74</b> hoặc <b>(08)39 15 15 15</b> để được hỗ trợ.";
                    break;
                case '7235':
                    $errMsg = 'Giao dịch không thực hiện được do tài khoản thanh toán đã bị khóa. Vui lòng liên hệ ngân hàng <b>Eximbank</b> qua số <b>1900 54 54 74</b> hoặc <b>(08)39 15 15 15</b> để được hỗ trợ.';
                    break;
                case "7201":
                    $errMsg = "Tài khoản của quý khách không đủ tiền để thanh toán.";
                    break;
                case "7202":
                    $errMsg = "Giao dịch không thực hiện được do không đảm bảo điều kiện số dư tối thiểu trong tài khoản.";
                    break;
                case "7213":
                    $errMsg = "Giao dịch không thực hiện được do thẻ/tài khoản chưa kích hoạt hoặc bị khóa.  Vui lòng liên hệ ngân hàng <b>BIDV</b> qua số <b>1800 1542</b> hoặc <b>(04)22 200 588</b> để được hỗ trợ.";
                    break;
                case "7211":
                    $errMsg = "Giao dịch không thực hiện được. Quý khách cần đăng ký dịch vụ <b>Thanh toán hóa đơn online</b> để thanh toán. <br> <b>+</b> Quý khách cần mang CMND và đăng ký dịch vụ tại quầy giao dịch của ngân hàng BIDV gần nhất.<br> <b>+</b> Hoặc vui lòng liên hệ ngân hàng <b>BIDV</b> qua số <b>1800 1542</b> hoặc <b>(04)22 200 588</b> để được hỗ trợ.";
                    break;
                case "7205":
                    $errMsg = "Giao dịch không thực hiện được do số tiền giao dịch vượt quá hạn mức cho phép trong một lần giao dịch.";
                    break;
            }
        } else {
            switch ($orderStatus) {
                case '7201':
                    $errMsg = 'Tài khoản quý khách không đủ để thực hiện giao dịch. Vui lòng kiểm tra lại.';
                    break;
                case '7202':
                    $errMsg = 'Tài khoản quý khách không đủ để thực hiện giao dịch. Vui lòng kiểm tra lại tài khoản (chú ý số dư tối thiểu theo qui định của ngân hàng).';
                    break;
                case '7211':
                    $errMsg = 'Quý khách chưa đăng ký sử dụng dịch vụ. Vui lòng thực hiện đăng ký dịch vụ theo hướng dẫn hoặc liên hệ với Ngân hàng để đuợc hướng dẫn thêm.';
                    break;
                case '7212':
                    $errMsg = 'Dịch vụ thanh toán trực tuyến của quý khách đang tạm khóa. Vui lòng liên hệ với Ngân hàng để đuợc hướng dẫn thêm.';
                    break;
                case '7213':
                    $errMsg = 'Thẻ/tài khoản chưa kích hoạt hoặc bị khóa. Vui lòng liên hệ với Ngân hàng để đuợc hướng dẫn thêm.';
                    break;
                case '7222':
                    $errMsg = 'Quý khách đã nhập sai OTP. Xin vui lòng kiểm tra lại.';
                    break;
                case '7231':
                    $errMsg = 'Thông tin về thẻ không đúng, xin vui lòng nhập lại hoặc liên hệ với Ngân hàng để đuợc hướng dẫn thêm.';
                    break;
                case '7232':
                    $errMsg = 'Thông tin về thẻ không hợp lệ. Vui lòng nhập lại hoặc liên hệ với ngân hàng của quý khách biết thêm thông tin thẻ.';
                    break;
                case '7233':
                    $errMsg = 'Thẻ đã hết hạn. Vui lòng kiểm tra lại.';
                    break;
                case '7234':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7235':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7255':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7299':
                    $errMsg = 'Ngân hàng từ chối giao dịch. Giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '7300':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '1000':
                    $errMsg = 'Dịch vụ internet đang bị gián đoạn, vui lòng thực hiện lại giao dịch.';
                    break;
                case '7223':
                    $errMsg = 'OTP đã hết thời gian hiệu lực. Quý khách vui lòng thực hiện lại giao dịch.';
                    break;
                case '7221':
                    $errMsg = 'Quý khách đã nhập sai thông tin thẻ 3 lần, vui lòng thực hiện lại giao dịch.';
                    break;
                case '7224':
                    $errMsg = 'Quý khách đã nhập OTP không đúng 3 lần. Vui lòng thực hiện giao dịch mới.';
                    break;
                /* case '7210':
                  $errMsg = 'Đã hết thời gian giao dịch, vui lòng thực hiện lại giao dịch khác.';
                  break; */
                case '7203':
                    $errMsg = 'Tổng số tiền quý khách thanh toán đã vượt quá mức cho phép trong ngày. Vui lòng thực hiện lại sau.';
                    break;
                case '7204':
                    $errMsg = 'Số lần giao dịch của quý khách đã vượt quá mức cho phép trong ngày. Vui lòng thực hiện lại sau.';
                    break;
                case '7205':
                    $errMsg = 'Quý khách đã thực hiện giao dịch với số tiền nhỏ hơn hạn mức cho phép. Vui lòng kiểm tra lại.';
                    break;
                case '7244':
                    $errMsg = 'Giao dịch không thành công do thẻ bị nghi ngờ không an toàn. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7246':
                case '7247':
                case '7248':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7252':
                    $errMsg = 'Thẻ chưa được xác thực. Vui lòng liên hệ ngân hàng của quý khách.';
                    break;
                case '7253':
                    $errMsg = 'Ngân hàng hủy giao dịch. Giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '7254':
                    $errMsg = 'Mật khẩu xác thực giao dịch trực tuyến (3D Secure) không đúng. Vui lòng kiểm tra lại.';
                    break;

                /* ---- 123pcc--- */
                case '3320':
                    $errMsg = 'Lỗi do hệ thống ngân hàng. Vui lòng thực hiện giao dịch khác.';
                    break;
                case '3345':
                    $errMsg = 'Thẻ không đủ tiền. Vui lòng thử lại giao dịch với thẻ khác.';
                    break;
                case '3352':
                    $errMsg = 'Hệ thống ngân hàng đang bận. Giao dịch đang được xử lý. Vui lòng xem lại lịch sử giao dịch trong vòng 30 phút.';
                    break;
                case '3353':
                    $errMsg = 'Số CVV không hợp lệ. Vui lòng thử lại giao dịch khác.';
                    break;
                case '3354':
                    $errMsg = 'Địa chỉ không hợp lệ. Vui lòng thử lại giao dịch khác.';
                    break;
                case '3355':
                    $errMsg = 'Địa chỉ và số CVV không hợp lệ. Vui lòng thử lại giao dịch khác.';
                    break;
                case '3356':
                    $errMsg = 'Giao dịch bị hủy vì thẻ không an toàn. Vui lòng thử lại giao dịch với thẻ khác.';
                    break;
                case '3357':
                    $errMsg = 'Ngân hàng từ chối giao dịch. Vui lòng thử lại giao dịch khác hoặc thẻ khác.';
                    break;
                case '3147':
                    $errMsg = 'Bạn đã nhập sai thông tin thẻ. Vui lòng nhập lại.';
                    break;
                case '4000':
                    $errMsg = 'Thẻ không hợp lệ. Vui lòng thử lại giao dịch khác.';
                    break;
                case '5':
                    $errMsg = 'Hệ thống không hỗ trợ thanh toán đối với thẻ này. Vui lòng thử lại giao dịch khác.';
                    break;

                case '6211':
                    $errMsg = 'Giao dịch của quý khách đã vượt quá số tiền quy định trong ngày. Vui lòng thực hiện lại vào ngày mai.';
                    break;
                case '7256':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị hạn chế sử dụng. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '6214':
                    $errMsg = 'Tài khoản của quý khách vượt quá số tiền thanh toán trong vòng 30 ngày khi mua ZingXu bằng thẻ Credit.';
                    break;
                case '6215':
                    $errMsg = 'Thẻ tín dụng của quý khách đã vượt quá giới hạn khi thanh toán (10 triệu đồng trong vòng 30 ngày) theo quy định của 123Pay.';
                    break;
                case '2110':
                    $errMsg = 'Quý khách đã nhập sai thông tin thẻ 3 lần, vui lòng thực hiện lại giao dịch.';
                    break;
                case '3348':
                    $errMsg = 'Thẻ của quý khách đã hết thời hạn thanh toán. Vui lòng liên hệ ngân hàng của bạn.';
                    break;
                case '3350':
                    $errMsg = 'Giao dịch của quý khách đang được xử lý, vui lòng đợi trong giây lát.';
                    break;
                case '3354':
                    $errMsg = 'Mã số bảo mật CVV/CVC không chính xác, vui lòng nhập lại.';
                    break;
                case '7245':
                    $errMsg = 'Ngân hàng từ chối giao dịch. Giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '7210':
                    $errMsg = 'Quý khách không nhập thông tin thanh toán. Giao dịch không thành công.';
                    break;
                case '7211':
                    $errMsg = 'Tài khoản của quý khách chưa đăng ký dịch vụ thanh toán trực tuyến. Vui lòng liên hệ ngân hàng của quý khách. Tham khảo dịch vụ cần đăng ký <a href="https://123pay.vn/help/index.html" target="_blank">tại đây</a>.';
                    break;
                case '7220':
                    $errMsg = 'Quý khách không nhập thông tin OTP. Giao dịch không thành công.';
                    break;
                case '7223':
                    $errMsg = 'OTP của quý khách đã hết hạn sử dụng. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '7224':
                    $errMsg = 'Quý khách đã nhập OTP không đúng quá 3 lần. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '7231':
                    $errMsg = 'Tên chủ thẻ không đúng. Vui lòng nhập lại hoặc liên hệ với ngân hàng của quý khách để biết thêm thông tin thẻ.';
                    break;
                case '7233':
                    $errMsg = 'Thẻ của quý khách đã hết thời hạn thanh toán. Vui lòng liên hệ ngân hàng của quý khách.';
                    break;
                case '7234':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7235':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7236':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7237':
                    $errMsg = 'Mật khẩu tài khoản/ thẻ không đúng. Vui lòng nhập lại hoặc liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7238':
                    $errMsg = 'Ngày phát hành thẻ không chính xác. Vui lòng kiểm tra lại.';
                    break;
                case '7239':
                    $errMsg = 'Ngày hết hạn không chính xác. Vui lòng kiểm tra lại.';
                    break;
                case '7241':
                    $errMsg = 'Mã số bảo mật CVV/CVC không đúng. Vui lòng kiểm tra lại hoặc liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7242':
                    $errMsg = 'Thông tin về địa chỉ thẻ không đúng. Vui lòng liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '7243':
                    $errMsg = 'Mã số bảo mật CVV/CVC và địa chỉ thẻ không đúng. Vui lòng kiểm tra lại hoặc liên hệ với ngân hàng của quý khách để biết thêm thông tin.';
                    break;
                case '0':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '900' :
                    $errMsg = 'Tài khoản ngân hàng của quý khách đã trừ tiền. Giao dịch đang được xử lý, vui lòng chờ trong giây lát.';
                    break;
                case '800':
                    $errMsg = 'Giao dịch bị hủy. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '80':
                    $errMsg = 'Giao dịch không tồn tại. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '1':
                    $errMsg = 'Giao dịch thành công.';
                    break;
                case '10':
                    $errMsg = 'Giao dịch đang được xử lý, vui lòng chờ trong giây lát.';
                    break;
                case '20':
                    $errMsg = 'Giao dịch đang được xử lý, vui lòng chờ trong giây lát.';
                    break;
                case '5000':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6000':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6100':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6200':
                    $errMsg = 'Hệ thống đang bận, giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6201':
                    $errMsg = 'Tài khoản 123Pay đã bị khóa. Vui lòng kiểm tra lại hoặc liên hệ số 1800 585 888 để được hướng dẫn thêm.';
                    break;
                case '6203':
                    $errMsg = '123Pay không hỗ trợ ngân hàng quý khách đã chọn. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6204':
                    $errMsg = 'Không tìm thấy giao dịch trong hệ thống. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '6206':
                    $errMsg = 'Giao dịch này đã được thực hiện trước đó. Vui lòng thực hiện giao dịch khác.';
                    break;
                case '6207':
                    $errMsg = 'Tài khoản 123Pay không tồn tại. Vui lòng kiểm tra lại hoặc liên hệ số 1800 585 888 để được hướng dẫn thêm.';
                    break;
                case '6211':
                    $errMsg = 'Giao dịch của quý khách đã vượt quá số tiền quy định trong ngày. Vui lòng thực hiện lại vào ngày mai.';
                    break;
                case '6212':
                    $errMsg = 'Giao dịch của quý khách đã vượt quá số tiền thanh toán trong một lần. Vui lòng thực hiện lại.';
                    break;
                case '6214':
                    $errMsg = 'Tài khoản của quý khách vượt quá số tiền thanh toán trong vòng 30 ngày.';
                    break;
                case '10':
                case '20':
                    $errMsg = 'Giao dịch đang được xử lý, vui lòng chờ trong giây lát.';
                    break;
                case '99':
                    $errMsg = 'Bạn đã nhập sai thông tin đăng ký OTP nhiều lần. Vui lòng quay lại sau.';
                    break;
                case '6216':
                    $errMsg = 'Vượt quá số lần thanh toán trong ngày, 123Pay qui định số lần thanh toán trong ngày.';
                    break;
                case '7230':
                    $errMsg = 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng phát hành biết thêm thông tin.';
                    break;
                case '88':
                    $errMsg = 'Giao dịch của quý khách chưa hoàn thành và chưa bị trừ tiền.<br>
					  Quý khách vui lòng thực hiện lại giao dịch và đăng ký số điện thoại nhận OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '7560':
                    $errMsg = 'Giao dịch không thành công do thẻ không được 123Pay hỗ trợ thanh toán.Vui lòng liên hệ  1800 585 888 để được hướng dẫn thêm.';
                    break;
                case '7209':
                    $errMsg = 'Quý khách hủy giao dịch. Giao dịch không thành công. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '-20':
                case '-21':
                case '-22':
                case '-23':
                    $errMsg = 'Giao dịch hủy. Vui lòng thực hiện giao dịch mới.';
                    break;
                case '-24':
                case '-25':
                    $errMsg = 'Quý khách không nhập thông tin thanh toán. Giao dịch không thành công.';
                    break;
                case '-26':
                    $errMsg = 'Giao dịch của quý khách chưa hoàn thành và chưa bị trừ tiền. <br>Quý khách vui lòng thực hiện lại giao dịch và đăng ký số điện thoại nhận OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '-27':
                    $errMsg = 'Giao dịch hủy. Vui lòng đăng ký nhận OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '-28':
                    $errMsg = 'Giao dịch của quý khách chưa hoàn thành và chưa bị trừ tiền.<br>Quý khách vui lòng thực hiện lại giao dịch và đăng ký số điện thoại nhận OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '-29':
                    $errMsg = 'Giao dịch hủy. Vui lòng đăng ký nhận OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '-30':
                    $errMsg = 'Giao dịch của quý khách chưa hoàn thành và chưa bị trừ tiền. <br>Quý khách vui lòng thực hiện lại giao dịch và nhập OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                case '-31':
                    $errMsg = 'Giao dịch hủy. Vui lòng nhập OTP để tiếp tục thanh toán với thẻ tín dụng qua 123Pay.';
                    break;
                default:
                    $errMsg = 'Hệ thống đang bận, giao dịch của quý khách chưa hoàn thành và chưa bị trừ tiền. Quý khách vui lòng thực hiện lại giao dịch mới.';
            }
        }
        return $errMsg;
    }

}