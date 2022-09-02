<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Prueba de Subir Imagen a SharePoint</title>
</head>
<body>
    <div class="w-5/6 rounded mt-8 border border-gray-400 mx-auto shadow-md">
        <div class="text-2xl text-center py-4 text-black">
            Prueba de Laravel + SharePoint
        </div>
        <div class="my-4 w-2/3 md:w1/2 mx-auto shadow-md overflow-hidden">
            <form action="{{route('cargar')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="p-4 items-center w-full">
                    <input id="file" name="file" type="file" accept="image/*,video/*" />
                </div>
                <div class="p-4 items-center w-full">
                    <select name="directory" id="directory"
                        class="border-gray-500 focus:border-pink-400 rounded border p-1">
                        <option value="">Select a Directory</option>
                        <option value="Prueba_imagenes">Images</option>
                        <option value="Videos">Videos</option>
                    </select>
                </div>
                <button type="submit" class="p-2 bg-[#ff1b8c] my-4 ml-4 text-white rounded-md font-medium hover:bg-[#303c4e]">Cargar Imagen</button>
                @error('file')
                    <div class="py-4 px-4 bg-red-200 border-l-4 border-red-600 my-4 mx-4 text-black font-medium">
                        {{ $message }}
                    </div>
                @enderror
                @error('directory')
                    <div class="py-4 px-4 bg-red-200 border-l-4 border-red-600 my-4 mx-4 text-black font-medium">
                        {{ $message }}
                    </div>
                @enderror
                @if (session()->has('msj'))
                    <div class="py-4 px-4 bg-green-200 border-l-4 border-green-600 my-4 mx-4 text-black font-medium">
                        {{ session('msj') }}
                    </div>
                @endif
                <div class="py-4 px-4 my-4 mx-4">
                    <a class="underline text-black hover:text-[#ff1b8c]"
                        href="{{route('file-list')}}">
                        See the list of files
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>