@props(['active' => false, 'type' => 'link'])

<{{ $type === 'button' ? 'button' : 'a' }} {{ $attributes}} aria-current="{{$active ? 'page' : 'false'}}"
class="rounded-md px-3 py-2 text-sm font-medium {{$active ? 'bg-gray-900 dark:bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white'}}">{{$slot}}</{{ $type === 'button' ? 'button' : 'a' }}>