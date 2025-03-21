import { usePage } from '@inertiajs/react';

const ChatHeaderLayout = ({children, breadcrumbs}) => {
    const page = usePage();

    return (
        <>{ children }</>
    );
}


export default  ChatHeaderLayout;
