@ -0,0 +1,135 @@
# Integración con Google Cloud Storage en Laravel

## 1. Instalación de Dependencias

Primero, necesitas instalar las dependencias de Google Cloud y Flysystem para Laravel:

```
composer require google/cloud-storage
composer require league/flysystem
```

## 2. Configuración en Google Cloud

### Crear Cuenta de Servicio

1. Ve a la [Google Cloud Console](https://console.cloud.google.com/).
2. Crea una nueva **Cuenta de Servicio** desde el menú **IAM y administración** > **Cuentas de servicio**.
3. Descarga el archivo JSON de claves de la cuenta de servicio.

### Configuración en Laravel

Agrega las siguientes variables a tu archivo `.env`:

```
GOOGLE_CLOUD_PROJECT_ID=tu-id-de-proyecto
GOOGLE_CLOUD_KEY_FILE_PATH=/ruta/a/tu/archivo-de-claves.json
GOOGLE_CLOUD_BUCKET_NAME=tu-nombre-de-bucket
```

En el archivo `config/filesystems.php`, agrega el siguiente disco para Google Cloud:

```
'disks' => [
    'google' => [
        'driver' => 'google',
        'project_id' => env('GOOGLE_CLOUD_PROJECT_ID'),
        'key_file' => env('GOOGLE_CLOUD_KEY_FILE_PATH'),
        'bucket' => env('GOOGLE_CLOUD_BUCKET_NAME'),
        'path_prefix' => null,
        'storage_api_uri' => null,
    ],
],
```

## 3. Subida de Imágenes

Si no tienes cuenta en GCP, puedes simular el proceso guardando las imágenes localmente. Para hacerlo, configura el almacenamiento local en `config/filesystems.php`:

```
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
    ],
    'google' => [
        'driver' => 'local',
        'root' => storage_path('app/google_storage'),
    ],
],
```

## 4. Crear Controlador para Subir Imagen

Crea un controlador para manejar la subida de imágenes para cada producto:

```
php artisan make:controller ProductImageController
```

Dentro del controlador `ProductImageController`, agrega el siguiente código:

```
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function upload(Request $request, $productId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $path = Storage::disk('google')->putFile('products/'.$productId, $image);

        $product = Product::find($productId);
        $product->image_path = $path;
        $product->save();

        return response()->json(['message' => 'Imagen subida correctamente', 'path' => $path]);
    }
}
```

## 5. Crear Ruta para Subir Imagen

Define una ruta en `routes/web.php` para la subida de imágenes:

```
Route::post('/product/{id}/upload-image', [ProductImageController::class, 'upload']);
```

## 6. Autenticación con Cuenta de Servicio

La autenticación con Google Cloud se maneja automáticamente usando el archivo JSON de la cuenta de servicio. Si necesitas autenticarte manualmente, usa el siguiente código:

```
use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'keyFilePath' => storage_path('app/google/credentials.json')
]);

$bucket = $storage->bucket(env('GOOGLE_CLOUD_BUCKET_NAME'));
```

## 7. Conclusión

Con la cuenta en GCP:

- Instala y configura el paquete `google/cloud-storage`.
- Sube las imágenes a tu bucket en GCS.

```

```

## Guía Adicional

Puedes consultar una guía completa sobre cómo subir archivos a Google Cloud Storage en Laravel [aquí](https://dev.to/iankumu/how-to-upload-filesimages-to-google-cloud-storage-in-laravel-4nf3).

```