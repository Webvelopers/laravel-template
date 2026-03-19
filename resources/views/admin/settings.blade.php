@php
    $isShadcn = ($frontendTemplate ?? 'default') === 'shadcn';
    $pageTitleClass = $isShadcn ? 'text-4xl font-semibold tracking-tight text-slate-950' : 'font-display text-4xl text-stone-950';
    $eyebrowClass = $isShadcn ? 'text-xs font-medium tracking-[0.28em] text-slate-500 uppercase' : 'text-sm font-semibold tracking-[0.35em] text-amber-700 uppercase';
    $bodyCopyClass = $isShadcn ? 'max-w-2xl text-base leading-8 text-slate-600' : 'max-w-2xl text-base leading-8 text-stone-600';
    $sectionCardClass = $isShadcn ? 'rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_-36px_rgba(15,23,42,0.25)]' : 'rounded-[2rem] border border-stone-200 bg-white/90 p-6 shadow-[0_24px_80px_-40px_rgba(120,53,15,0.45)]';
    $fieldLabelClass = $isShadcn ? 'block space-y-2 text-sm font-medium text-slate-700' : 'block space-y-2 text-sm font-medium text-stone-700';
    $sectionTitleClass = $isShadcn ? 'text-2xl font-semibold tracking-tight text-slate-950' : 'font-display text-2xl text-stone-950';
    $sectionDescriptionClass = $isShadcn ? 'mt-2 text-sm leading-7 text-slate-500' : 'mt-2 text-sm leading-7 text-stone-500';
    $tableWrapClass = $isShadcn ? 'mt-6 overflow-hidden rounded-[1.25rem] border border-slate-200 bg-white' : 'mt-6 overflow-hidden rounded-[1.5rem] border border-stone-200 bg-white';
    $tableHeaderClass = $isShadcn ? 'bg-slate-50 text-left text-xs font-medium tracking-[0.18em] text-slate-500 uppercase' : 'bg-stone-50 text-left text-xs font-semibold tracking-[0.22em] text-stone-500 uppercase';
    $tableCellClass = $isShadcn ? 'border-t border-slate-200 px-4 py-4 text-sm text-slate-700' : 'border-t border-stone-200 px-4 py-4 text-sm text-stone-700';
    $capabilityCardClass = $isShadcn ? 'rounded-[1.25rem] border border-slate-200 bg-slate-50 p-5' : 'rounded-[1.5rem] border border-stone-200 bg-stone-50 p-5';
    $badgeClass = $isShadcn ? 'inline-flex rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium tracking-[0.18em] text-slate-600 uppercase' : 'inline-flex rounded-full border border-stone-200 bg-white px-3 py-1 text-xs font-semibold tracking-[0.22em] text-stone-700 uppercase';
    $checkboxWrapClass = $isShadcn ? 'flex items-start gap-3 rounded-xl border border-slate-200 bg-white p-3' : 'flex items-start gap-3 rounded-2xl border border-stone-200 bg-white p-3';
    $inputClass = $isShadcn ? 'w-full rounded-md border border-slate-300 bg-white px-4 py-3 text-slate-900 transition outline-none focus:border-slate-950 focus:ring-2 focus:ring-slate-950/10' : 'w-full rounded-2xl border border-stone-300 bg-stone-50 px-4 py-3 text-stone-900 transition outline-none focus:border-stone-900 focus:bg-white';
    $primaryButtonClass = $isShadcn ? 'rounded-md bg-slate-950 px-5 py-3 text-sm font-medium text-white transition hover:bg-slate-800' : 'rounded-full bg-stone-900 px-5 py-3 text-sm font-semibold text-amber-50 transition hover:bg-stone-700';
    $secondaryButtonClass = $isShadcn ? 'rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50' : 'rounded-full border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700 transition hover:border-stone-900 hover:bg-white';
@endphp

<x-layouts.app :title="__('frontend.admin.title')">
    <section class="space-y-8">
        <div class="space-y-2">
            <p class="{{ $eyebrowClass }}">{{ __('frontend.admin.eyebrow') }}</p>
            <h1 class="{{ $pageTitleClass }}">{{ __('frontend.admin.headline') }}</h1>
            <p class="{{ $bodyCopyClass }}">{{ __('frontend.admin.description') }}</p>
        </div>

        <x-status-banner :status="session('status')" />

        <section class="{{ $sectionCardClass }}">
            <h2 class="{{ $sectionTitleClass }}">{{ __('frontend.admin.human_verification_title') }}</h2>
            <p class="{{ $sectionDescriptionClass }}">{{ __('frontend.admin.human_verification_description') }}</p>

            <form method="POST" action="{{ route('human-verification.update') }}" class="mt-6 space-y-4">
                @csrf

                <label class="{{ $fieldLabelClass }}">
                    <span>{{ __('frontend.admin.human_verification_field') }}</span>
                    <select name="registration_human_verification_enabled" class="{{ $inputClass }}">
                        <option value="0" @selected(! $registrationHumanVerificationEnabled)>
                            {{ __('frontend.profile.human_verification_options.disabled') }}
                        </option>
                        <option value="1" @selected($registrationHumanVerificationEnabled)>
                            {{ __('frontend.profile.human_verification_options.enabled') }}
                        </option>
                    </select>
                </label>

                <x-input-error :messages="$errors->get('registration_human_verification_enabled')" />

                <button type="submit" class="{{ $primaryButtonClass }}">
                    {{ __('frontend.admin.save_settings') }}
                </button>
            </form>
        </section>

        <section class="{{ $sectionCardClass }}">
            <h2 class="{{ $sectionTitleClass }}">{{ __('frontend.admin.roles_title') }}</h2>
            <p class="{{ $sectionDescriptionClass }}">{{ __('frontend.admin.roles_description') }}</p>

            <div class="mt-6 grid gap-4 lg:grid-cols-2">
                @foreach ($availableRoles as $availableRole)
                    <article class="{{ $capabilityCardClass }} space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <h3
                                class="{{ $isShadcn ? 'text-lg font-semibold text-slate-950' : 'font-display text-xl text-stone-950' }}"
                            >
                                {{ $availableRole['label'] }}
                            </h3>
                            <span class="{{ $badgeClass }}">{{ $availableRole['value'] }}</span>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('admin.roles.capabilities.update', $availableRole['value']) }}"
                            class="space-y-4"
                        >
                            @csrf
                            @method('PUT')

                            <div class="space-y-2">
                                <p class="{{ $sectionDescriptionClass }} mt-0">
                                    {{ __('frontend.admin.capabilities_title') }}
                                </p>

                                <div class="space-y-3">
                                    @foreach (\App\Enums\UserRole::allCapabilityKeys() as $capability)
                                        @php
                                            $checked = in_array($capability, $availableRole['capabilities'], true);
                                            $protected = in_array($capability, $availableRole['protected_capabilities'], true);
                                        @endphp

                                        <label class="{{ $checkboxWrapClass }}">
                                            <input
                                                type="checkbox"
                                                name="capabilities[]"
                                                value="{{ $capability }}"
                                                @checked($checked)
                                                @disabled($protected)
                                                class="mt-1 h-4 w-4 rounded border-slate-300 text-slate-950 focus:ring-slate-950"
                                            />

                                            @if ($protected && $checked)
                                                <input type="hidden" name="capabilities[]" value="{{ $capability }}" />
                                            @endif

                                            <span class="space-y-1">
                                                <span
                                                    class="{{ $isShadcn ? 'text-sm font-medium text-slate-900' : 'text-sm font-semibold text-stone-900' }} block"
                                                >
                                                    {{ __('frontend.admin.capabilities.' . $capability . '.title') }}
                                                </span>
                                                <span
                                                    class="{{ $isShadcn ? 'text-xs leading-6 text-slate-500' : 'text-xs leading-6 text-stone-500' }} block"
                                                >
                                                    {{ __('frontend.admin.capabilities.' . $capability . '.description') }}
                                                </span>
                                                @if ($protected)
                                                    <span
                                                        class="{{ $isShadcn ? 'text-xs text-slate-500' : 'text-xs text-stone-500' }} block"
                                                    >
                                                        {{ __('frontend.admin.protected_capability') }}
                                                    </span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="{{ $secondaryButtonClass }}">
                                {{ __('frontend.admin.update_capabilities') }}
                            </button>
                        </form>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="{{ $sectionCardClass }}">
            <h2 class="{{ $sectionTitleClass }}">{{ __('frontend.admin.user_roles_title') }}</h2>
            <p class="{{ $sectionDescriptionClass }}">{{ __('frontend.admin.user_roles_description') }}</p>

            <div class="{{ $tableWrapClass }}">
                <table class="min-w-full border-collapse">
                    <thead class="{{ $tableHeaderClass }}">
                        <tr>
                            <th class="px-4 py-3">{{ __('frontend.admin.user_name') }}</th>
                            <th class="px-4 py-3">{{ __('frontend.admin.user_email') }}</th>
                            <th class="px-4 py-3">{{ __('frontend.admin.user_role') }}</th>
                            <th class="px-4 py-3">{{ __('frontend.admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $managedUser)
                            @php
                                $assignedRole = $roleAssignments[$managedUser->id] ?? \App\Enums\UserRole::User->value;
                            @endphp

                            <tr>
                                <td class="{{ $tableCellClass }}">{{ $managedUser->name }}</td>
                                <td class="{{ $tableCellClass }}">{{ $managedUser->email }}</td>
                                <td class="{{ $tableCellClass }}">
                                    <span class="{{ $badgeClass }}">{{ __('frontend.roles.' . $assignedRole) }}</span>
                                </td>
                                <td class="{{ $tableCellClass }}">
                                    @if (auth()->id() === $managedUser->id)
                                        <span
                                            class="{{ $isShadcn ? 'text-sm text-slate-500' : 'text-sm text-stone-500' }}"
                                        >
                                            {{ __('frontend.admin.current_admin_account') }}
                                        </span>
                                    @else
                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.role.update', $managedUser) }}"
                                            class="flex flex-col gap-3 md:flex-row md:items-center"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <select name="role" class="{{ $inputClass }} max-w-xs">
                                                @foreach ($availableRoles as $availableRole)
                                                    <option
                                                        value="{{ $availableRole['value'] }}"
                                                        @selected($assignedRole === $availableRole['value'])
                                                    >
                                                        {{ $availableRole['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="{{ $secondaryButtonClass }}">
                                                {{ __('frontend.admin.update_role') }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-input-error :messages="$errors->get('role')" class="mt-4" />
        </section>
    </section>
</x-layouts.app>
