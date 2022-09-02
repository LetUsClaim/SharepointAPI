<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>File's List</title>
</head>
<body>
    <div class="w-5/6 rounded mt-8 border border-gray-400 mx-auto shadow-md">
        <div class="text-2xl text-center py-4 text-black">
            File's List in SharePoint
        </div>
        <div class="my-4 w-2/3 md:w1/2 mx-auto shadow-md overflow-hidden">
            @if (session()->has('msj'))
                <div class="py-4 px-4 bg-green-200 border-l-4 border-green-600 my-4 mx-4 text-black font-medium">
                    {{ session('msj') }}
                </div>
            @endif
            <div class="py-4 px-4 my-2">
                <a class="text-white bg-[#ff1b8c] hover:bg-[#303c4e] p-2 rounded"
                    href="{{route('subir-imagen')}}">
                    Upload File
                </a>
            </div>
            <div class="p-2">
                <table class="w-full">
                    <thead>
                        <tr class="w-full p-2 font-bold bg-[#ff1b8c] text-lg text-white">
                            <th class="w-1/6">Preview</th>
                            <th class="w-1/3">SharePoint Directory</th>
                            <th class="w-1/6">File</th>
                            <th class="w-1/6">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>
                                    <img src="{{ 'https://letusclaimcons.sharepoint.com/sites/pruebalaravelsharepoint/'.$file->directory.'/'.$file->file }}" alt="{{$file->file}}">
                                </td>
                                <td class="text-center">{{$file->directory}}</td>
                                <td class="text-center">{{$file->file}}</td>
                                <td>
                                    <div class="m-2 flex justify-around text-center">
                                        <a class="p-2 bg-[#ff1b8c] my-2 ml-4 text-white rounded-md font-medium hover:bg-[#303c4e]"
                                            href="{{route('file-download', $file->id)}}" title="Download from SharePoint">
                                            <x-icons.cloud-download />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
