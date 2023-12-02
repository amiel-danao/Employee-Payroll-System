<script setup>
import NavLink from "@/Components/NavLink.vue";
import GoBackNavLink from "@/Components/GoBackNavLink.vue";
</script>

<template>
    <GoBackNavLink/>

    <div v-if="$page.props.auth.user.roles.includes('admin')" class="space-x-8 rtl:space-x-reverse sm:flex">
        <NavLink :href="route('zzz.index')" :active="route().current('zzz.index')">
            {{__('All Tasks')}}
        </NavLink>
        <NavLink :href="route('zzz.create')" :active="route().current('zzz.create')">
            {{__('Create a Task')}}
        </NavLink>
    </div>

    <div v-else class="space-x-8 sm:flex">
        <NavLink :href="route('zzz.index')" :active="route().current('zzz.index') || route().current('tasks.show') ">
            {{__('All Tasks')}}
        </NavLink>
    </div>


</template>

