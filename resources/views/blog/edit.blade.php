<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>
    @vite('resources/css/app.css')
</head>

<body>
<div class="w-4/5 mx-auto">
    <div class="text-center pt-20">
        <h1 class="text-3xl text-gray-700">
            Edit {{ $post->title }}
        </h1>
        <hr class="border border-1 border-gray-300 mt-10">
    </div>

    <div class="m-auto pt-20">

        @if ($errors->any())
            <div class="pb-8 ">
                <div class="bg-red-500 text-white font-bold rounded-top px-4 py-2 text-center">
                    Something went wrong
                </div>
                <ul
                    class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3
                    text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('blog.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label for="is_published" class="block text-gray-500 text-lg mb-4">
                Is Published
                <input type="checkbox" class=""
                       name="is_published" {{ $post->is_published ? 'checked' : '' }}>
            </label>

            <label>
                <input type="text" name="title" value="{{ $post->title }}"
                       class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none">
            </label>

            <label>
                <input type="text" name="excerpt" value="{{ $post->excerpt }}"
                       class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none">
            </label>

            <label>
                <input type="number" name="min_to_read" value="{{ $post->min_to_read }}"
                       class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none">
            </label>

            <label>
                <textarea name="body" class="py-20 bg-transparent block border-b-2 w-full h-60 text-xl outline-none resize-none">{{ $post->body }}
                </textarea>
            </label>

            <div class="bg-grey-lighter py-10">
                <label
                    class="w-44 flex flex-col items-center px-2 py-3 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
                        <span class="mt-2 text-base leading-normal">
                            Select a file
                        </span>
                    <input type="file" name="image_path" class="hidden">
                </label>
            </div>
{{--            @dd($post->meta)--}}
            <input type="text" name="meta_description"
                   value="{{ $post->meta->meta_description ?  $post->meta->meta_description : "add a meta description" }}" class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none">
            <input type="text" name="meta_keywords" value="{{ $post->meta->meta_keywords ?  $post->meta->meta_keywords : "add some keywords" }}"
                   class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none">
            <input type="text" name="meta_robots" value="{{ $post->meta->meta_robots ?  $post->meta->meta_robots : "add meta robots" }}"
                   class="bg-transparent block border-b-2 w-full h-20 text-xl outline-none mb-2">
            <button type="submit"
                    class="uppercase mt-15 bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl">
                Submit Post
            </button>
        </form>
    </div>
</div>
</body>

</html>
