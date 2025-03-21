import { usePage } from '@inertiajs/react';
import { ChatSidebar } from '@/components/chat-sidebar';
import { AppContent } from '@/components/app-content';
import { ChatShell } from '@/components/chat-shell';
import ChatHeaderLayout from '@/layouts/chat/chat-header-layout';
import { useEffect, useState } from 'react';

const ChatSidebarLayout = ({children, breadcrumbs = []}) => {
    const page = usePage();
    const conversations = page.props.conversations;
    const selectedConversation = page.props.selectedConversation;
    const [onlineUsers, setOnlineUsers] = useState({});

    console.log("conversations :", conversations);
    console.log("selectedConversation ", selectedConversation);

    useEffect(() => {
        Echo.join('online')
            .here((users)=>{
                const onlineUsersObj = Object.fromEntries(
                    users.map((user) => [user.id, user])
                );
                setOnlineUsers((prevOnlineUsers) => {
                    return { ...prevOnlineUsers, ...onlineUsersObj}
                })
            })
            .joining((user)=>{
                setOnlineUsers((prevOnlineUsers) => {
                    const updatedUsers = { ...prevOnlineUsers };
                    updatedUsers[user.id] = user;
                    return updatedUsers;
                })
            })
            .leaving((user)=>{
                setOnlineUsers((prevOnlineUsers) => {
                    const updatedUsers = { ...prevOnlineUsers };
                    delete updatedUsers[user.id];
                    return updatedUsers;
                })
            })
            .error((error)=>{
                console.log("error", error)
            })
    }, [])
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
