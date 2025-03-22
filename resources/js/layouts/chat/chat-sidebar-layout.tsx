import { usePage } from '@inertiajs/react';
import { ChatSidebar } from '@/components/chat-sidebar';
import { AppContent } from '@/components/app-content';
import { ChatShell } from '@/components/chat-shell';
import ChatHeaderLayout from '@/layouts/chat/chat-header-layout';
import { useEffect, useState, useMemo } from 'react';

const ChatSidebarLayout = ({children, breadcrumbs = []}) => {
    const page = usePage();
    const conversations = useMemo(() => page.props.conversations ?? [], [page.props.conversations])
    const selectedConversation = page.props.selectedConversation;
    const [onlineUsers, setOnlineUsers] = useState([]);
    const [localConversations, setLocalConversations] = useState([]);
    const [sortedConversations, setSortedConversations] = useState([]);

    const isUserOnline = (userId) => onlineUsers[userId];

    console.log("conversations :", conversations);
    console.log("selectedConversation ", selectedConversation);

    useEffect(() => {
        setSortedConversations(
            localConversations.sort((a,b) => {
                if(a.blocked_at && b.blocked_at) {
                    return a.blocked_at > b.blocked_at ? 1 : -1;
                }else if(a.blocked_at){
                    return 1;
                }else if (b.blocked_at){
                    return -1;
                }
                if (a.last_message_date && b.last_message_date){
                    return b.last_message_date.localeCompare(a.last_message_date)
                } else if (a.last_message_date){
                    return -1
                } if ( b.last_message_date){
                    return 1
                }else return 0;
            })
        )
    }, [localConversations]);

    useEffect(() => {
        setLocalConversations(conversations)
    }, [conversations]);

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
