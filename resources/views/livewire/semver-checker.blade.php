@php
    /** @var \Packagist\Api\Result\Package[] $results */
@endphp

<div>
    <p class="mb-3 text-sm">
        <a target="_blank" href="https://getcomposer.org/doc/articles/versions.md#versions-and-constraints">Learn more about version constraints</a>
    </p>

    <section>
        <form class="flex">
            <input
                wire:model.debounce.250ms="package"
                placeholder="Package"
                id="package"
                type="text"
                autofocus=""
                class="@if ($package === null) border-red-500 @endif flex-grow text-center border-2 border-gray-400 bg-gray-100 p-3 text-gray-400 focus:text-gray-500 outline-none mr-3 text-lg font-bold"
            >
            <input wire:model="constraint" placeholder="Version (eg. ^1.5)" id="version" type="text"  class="@if (!$this->isValidConstraint) border-red-500 @endif flex-grow text-center border-2 border-gray-400 bg-gray-100 p-3 text-gray-400 focus:text-gray-500 outline-none mr-3 text-lg font-bold">
            @unless($isVirtual)
                <select name="stability" id="stability" wire:model="stability" class="text-center border-2 border-gray-400 bg-gray-100 p-3 text-gray-400 focus:text-gray-500 outline-none mr-3 text-lg font-bold">
                    <option label="dev" value="dev">dev</option>
                    <option label="alpha" value="alpha">alpha</option>
                    <option label="beta" value="beta">beta</option>
                    <option label="RC" value="RC">RC</option>
                    <option label="stable" value="stable">stable</option>
                </select>
            @endif
        </form>

        @if(!empty($versions))
            <section class="text-center mt-5 pt-5 border-t border-gray-100">
                <h1 class="text-lg text-gray-600 font-medium mb-5">Results for <a target="_blank" href="https://packagist.org/packages/{{ $package }}">{{ $package }}:{{ $constraint }}</a></h1>

                <ul class="versions">
                    @foreach ($versions as $version)
                        <li
                            @if ($version->matches())
                            class="matches"
                            @endif
                        >
                            <a target="_blank" href="{{ $version->getUrl() }}">{{ $version->getName() }}</a>
                        </li>
                    @endforeach
                </ul>
            </section>

            @unless($isVirtual)
                <h2 class="text-center text-lg text-gray-600 my-5 font-medium">Satisfied?</h2>
                <pre class="bg-gray-100 p-3 text-sm text-gray-600">composer require {{ $package }}:&quot;{{ $constraint }}{{ $this->stabilityFlag }}&quot;</pre>
            @endif
        @elseif(!empty($package))
            <section class="mt-5 pt-5 border-t border-gray-100">
                <h1 class="text-lg text-gray-600 font-medium mb-5">Known packages</h1>
                @if(!empty($results))
                    <ul>
                        @foreach($results as $result)
                            <li>
                                <a wire:click="choosePackage('{{ $result->getName() }}')">{{ $result->getName() }}</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-lg text-gray-500"><em>No packages found for "{{ $package }}".</em></p>
                @endif
            </section>
        @endif
    </section>
</div>
