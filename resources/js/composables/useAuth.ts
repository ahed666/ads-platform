// resources/js/composables/useAuth.ts
import { usePage } from '@inertiajs/vue3';
import type { Auth } from '@/types';

export const useAuth = () => {
  const page = usePage();
  return page.props.auth as Auth;
};
