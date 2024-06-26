<h1><p align="center">think-filesystem</p></h1>
<p align="center"> thinkphp6.1+ 的文件系统扩展包，支持上传阿里云OSS和七牛和腾讯云COS和华为云OBS和awsS3</p>

## 包含

1. php >= 8.0.2
2. thinkphp >=6.1

## 支持

1. 阿里云
2. 七牛云

## 安装

第一步：

```shell
$ composer require vietrue/think-filesystem
```

第二步： 在config/filesystem.php中添加配置

```php
'aliyun' => [
    'type'         => 'aliyun',
    'accessId'     => '******',
    'accessSecret' => '******',
    'endpoint'     => 'oss-cn-shenzhen.aliyuncs.com',
    'bucket'       => '******',
    'domain'       => '',
    'throw'        => true,
    'isCName'       => true,
    'cdnUrl'=>'',
    'prefix'        => '',
    'options'       => [
          'endpoint'        => '',
          'bucket_endpoint' => '',
     ],
],
'qiniu'  => [
    'type'      => 'qiniu',
    'accessKey' => '******',
    'secretKey' => '******',
    'bucket'    => '******',
    'domain'    => '******',
    'throw'     => true,
],
```

第三步： 开始使用。 请参考thinkphp文档
文档地址：[https://www.kancloud.cn/manual/thinkphp6_0/1037639 ](https://www.kancloud.cn/manual/thinkphp6_0/1037639 )

### demo

```php
$file = $this->request->file( 'image' );
      try {
            validate(
                ['image' => [
                        // 限制文件大小(单位b)，这里限制为4M
                        'fileSize' => 10 * 1024 * 1000,
                        // 限制文件后缀，多个后缀以英文逗号分割
                        'fileExt'  => 'gif,jpg,png,jpeg'
                    ]
                ])->check( ['image' => $file] );

            $path     = \yzh52521\filesystem\facade\Filesystem::disk( 'public' )->putFile( 'test',$file);
            $url      = \yzh52521\filesystem\facade\Filesystem::disk( 'public' )->url( $path );
            return json( ['path' => $path,'url'  => $url] );
      } catch ( \think\exception\ValidateException $e ) {
            echo $e->getMessage();
     }
```

## 检索文件
> get  方法可用于检索文件的内容。该方法将返回文件的原始字符串内容。
切记，所有文件路径的指定都应该相对于该磁盘所配置的「root」目录：

```php
$contents = Filesystem::get('file.jpg');
```

>exists 方法可以用来判断一个文件是否存在于磁盘上：

```php
if (Filesystem::disk('local')->exists('file.jpg')) {
    // ...
}
```
>missing 方法可以用来判断一个文件是否缺失于磁盘上：
```php
if (Filesystem::disk('local')->missing('file.jpg')) {
    // ...
}
```
## 下载文件

>download 方法可以用来生成一个响应，强制用户的浏览器下载给定路径的文件。
download 方法接受一个文件名作为方法的第二个参数，这将决定用户下载文件时看到的文件名。最后，你可以传递一个 HTTP 头部的数组作为方法的第三个参数：

```php
return Filesystem::download('file.jpg');

return Filesystem::download('file.jpg', $name, $headers);
```
## 文件 URL

>你可以使用 url 方法来获取给定文件的 URL。如果你使用的是 local 驱动，这通常只会在给定路径前加上 /storage，并返回一个相对 URL 到文件。如果你使用的是 local 驱动，将返回完全限定的远程 URL：
```php
$url = Filesystem::url('file.jpg');
```
## 文件元数据
>除了读写文件，还可以提供有关文件本身的信息。例如，size 方法可用于获取文件大小（以字节为单位）：

```php
$size = Filesystem::size('file.jpg');
```
>lastModified 方法返回上次修改文件时的时间戳：
```php
$time = Filesystem::lastModified('file.jpg');
```
>可以通过 mimeType 方法获取给定文件的 MIME 类型：
```php
$mime = Filesystem::mimeType('file.jpg')
```

## 文件路径
>你可以使用 path 方法获取给定文件的路径。如果你使用的是 local 驱动，这将返回文件的绝对路径。如果你使用的是 aliyun 驱动，此方法将返回 aliyun 存储桶中文件的相对路径：

```php
$path = Filesystem::path('file.jpg');
```

## 保存文件
>可以使用 put 方法将文件内容存储在磁盘上。你还可以将 PHP resource 传递给 put 方法，该方法将使用 Flysystem 的底层流支持。请记住，应相对于为磁盘配置的「根」目录指定所有文件路径：
```php
Filesystem::put('file.jpg', $contents);

Filesystem::put('file.jpg', $resource);
```
## 写入失败

>如果 put 方法（或其他「写入」操作）无法将文件写入磁盘，将返回 false。
```php
if (! Filesystem::put('file.jpg', $contents)) {
    // 该文件无法写入磁盘...
}
```
>你可以在你的文件系统磁盘的配置数组中定义 throw 选项。当这个选项被定义为 true 时，「写入」的方法如 <code>put</code> 将在写入操作失败时抛出一个 League\Flysystem\UnableToWriteFile 的实例。

```php
'public' => [
    'type' => 'local',
    // ...
    'throw' => true,
],
```

## 追加内容到文件开头或结尾
>prepend 和 append 方法允许你将内容写入文件的开头或结尾：
```php
Filesystem::prepend('file.log', 'Prepended Text');

Filesystem::append('file.log', 'Appended Text');
```
## 复制/移动文件
>copy 方法可用于将现有文件复制到磁盘上的新位置，而 move 方法可用于重命名现有文件或将其移动到新位置：

```php
Filesystem::copy('old/file.jpg', 'new/file.jpg');

Filesystem::move('old/file.jpg', 'new/file.jpg');
```
## 自动流式传输
>将文件流式传输到存储位置可显著减少内存使用量。如果你希望 thinkphp 自动管理将给定文件流式传输到你的存储位置，你可以使用 putFile 或 putFileAs 方法。此方法接受一个 think\File 或 think\file\UploadedFile 实例，并自动将文件流式传输到你所需的位置：

```php
use think\File;

// 为文件名自动生成一个唯一的 ID...
$path = Filesystem::putFile('photos', new File('/path/to/photo'));

// 手动指定一个文件名...
$path = Filesystem::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
```

>关于 putFile 方法有几点重要的注意事项。注意，我们只指定了目录名称而不是文件名。默认情况下，putFile 方法将生成一个唯一的 ID 作为文件名。文件的扩展名将通过检查文件的 MIME 类型来确定。文件的路径将由 putFile方法返回，因此你可以将路径（包括生成的文件名）存储在数据库中。
putFile 和 putFileAs 方法还接受一个参数来指定存储文件的「可见性」。如果你将文件存储在云盘（如 Amazon S3）上，并希望文件通过生成的 URL 公开访问，这一点特别有用：

```php
Filesystem::putFile('photos', new File('/path/to/photo'), 'public');
```
## 删除文件
>delete 方法接收一个文件名或一个文件名数组来将其从磁盘中删除：
```php
Filesystem::delete('file.jpg');

Filesystem::delete(['file.jpg', 'file2.jpg']);
```
如果需要，你可以指定应从哪个磁盘删除文件。
```php
Filesystem::disk('s3')->delete('path/file.jpg');
```
## 目录
### 获取目录下所有的文件
>files 将以数组的形式返回给定目录下所有的文件。如果你想要检索给定目录的所有文件及其子目录的所有文件，你可以使用 allFiles 方法：
```php
$files = Filesystem::files($directory);
$files = Filesystem::allFiles($directory);
```
### 获取特定目录下的子目录
>directories 方法以数组的形式返回给定目录中的所有目录。此外，你还可以使用
allDirectories 方法递归地获取给定目录中的所有目录及其子目录中的目录：

```php
$directories = Filesystem::directories($directory);
$directories = Filesystem::allDirectories($directory);
```
### 创建目录
>makeDirectory 方法可递归的创建指定的目录:

```php
Filesystem::makeDirectory($directory);
```
### 删除一个目录
>最后，deleteDirectory 方法可用于删除一个目录及其下所有的文件：
```php
Filesystem::deleteDirectory($directory);
```
## 自定义文件系统
>你可以在 系统服务 中注册一个带有 boot 方法的驱动。在提供者的 boot 方法中，你可以使用 Filesystem 门面的 extend 方法来定义一个自定义驱动：

```php
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client as DropboxClient;
use Spatie\FlysystemDropbox\DropboxAdapter;

class AppService extends Service
{
    public function boot()
    {
        Filesystem::extend('dropbox', function (App $app, array $config) {
            $adapter = new DropboxAdapter(new DropboxClient(
                $config['authorization_token']
            ));
           return new Filesystem($adapter, $config),
        });
   }
}
```
extend 方法的第一个参数是驱动程序的名称，第二个参数是接收 $app 和 $config 变量的闭包。闭包必须返回的实例 League\Flysystem\Filesystem。$config 变量包含 config/filesystems.php 为指定磁盘定义的值。
## 授权

MIT

## 感谢

1. thinkphp
3. overtrue/flysystem-qiniu
4. league/flysystem
5. overtrue/flysystem-cos