# easyupload

Simple File Upload System 簡易檔案上傳系統
pwdx下的user.txt裡面可以設定用戶名稱與密碼，密碼是值md5(md5(md5(密碼)))。每行一個用戶名稱和密碼用「|」分隔。
上傳完檔案會存放在/upload/用戶名稱/，並禁止任何人直接透過HTTP訪問。
