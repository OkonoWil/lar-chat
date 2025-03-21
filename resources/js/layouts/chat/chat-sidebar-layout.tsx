import { usePage } from '@inertiajs/react';
import { ChatSidebar } from '@/components/chat-sidebar';
import { AppContent } from '@/components/app-content';
import { ChatShell } from '@/components/chat-shell';
import ChatHeaderLayout from '@/layouts/chat/chat-header-layout';

const ChatSidebarLayout = ({children, breadcrumbs = []}) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversation = page.props.selectedConversation;

    console.log("conversations :", conversations);
    console.log("selectedConversation ", selectedConversation);

    return (
        <ChatShell variant="sidebar">
            <ChatSidebar />
            <AppContent variant="sidebar">
                <ChatHeaderLayout breadcrumbs={breadcrumbs} />
                {children}
            </AppContent>
        </ChatShell>
    );
}


export default  ChatSidebarLayout;
